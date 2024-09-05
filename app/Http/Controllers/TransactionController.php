<?php

namespace App\Http\Controllers;

use App\Imports\TransactionsImport;
use App\Models\Account;
use App\Models\Category;
use App\Models\LedgerEntry;
use App\Models\MonthlyBalance;
use App\Models\NoteTransaction;
use Illuminate\Http\Request;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class TransactionController extends Controller
{
    protected $transactionModel;

    public function __construct(Transaction $transaction)
    {
        $this->transactionModel = $transaction;
    }

    public function index(Request $request)
    {
        $accountCode = $request->query('account');
        $startDate = $request->query('start_date', today()->toDateString());
        $endDate = $request->query('end_date', today()->toDateString());

        $startDate = Carbon::parse($startDate)->startOfDay()->toDateTimeString();
        $endDate = Carbon::parse($endDate)->endOfDay()->toDateTimeString();

        if ($request->ajax()) {
            $query = LedgerEntry::with(['transaction.category'])->whereBetween('entry_date', [$startDate, $endDate]);

            if ($accountCode) {
                $query->where('account_code', $accountCode);
            } else {
                $query->whereHas('account', function ($query) {
                    $query->where('position', 'asset')->whereNotIn('code', ['101', '102', '103']);
                });
            }


            return DataTables::of($query)
                ->addColumn('id', function ($entry) {
                    return $entry->id;
                })
                ->addColumn('description', function ($entry) {
                    return $entry->transaction->description ?? 'N/A';
                })
                ->addColumn('category_name', function ($entry) {
                    return $entry->transaction->category->name ?? 'N/A';
                })
                ->addColumn('debit', function ($entry) {
                    return $entry->entry_type == 'debit' ? number_format($entry->amount, 0, ',', '.') : '0';
                })
                ->addColumn('credit', function ($entry) {
                    return $entry->entry_type == 'credit' ? number_format($entry->amount, 0, ',', '.') : '0';
                })
                ->addColumn('balance', function ($entry) {
                    return  number_format($entry->balance, 0, ',', '.') ?? 'N/A';
                })
                ->addColumn('action', function ($entry) {
                    return '<div class="action">
                                <button class="text-danger delete-button" data-id="' . $entry->transaction->id . '">
                                    <i class="lni lni-trash-can"></i>
                                </button>
                            </div>';
                })
                ->addColumn('view_image', function ($entry) {
                    if ($entry->transaction->noteTransaction && $entry->transaction->noteTransaction->img_src) {
                        return '<div class="action"><button class="view-image-btn" data-bs-toggle="modal" data-bs-target="#imageModal" data-image="' . asset('storage/' . $entry->transaction->noteTransaction->img_src) . '">
                                    <i class="lni lni-eye"></i>
                                </button></div>';
                    }
                    return '';
                })
                ->rawColumns(['action', 'view_image'])
                ->make(true);
        }


        $account = Account::find($accountCode);
        $inCategories = null;
        $outCategories = null;
        $totalBalance = 0;
        $startingBalance = 0;

        $query = LedgerEntry::whereBetween('entry_date', [$startDate, $endDate]);
        if ($account) {
            $ledgerEntries = $query->where('account_code', $accountCode)->get();

            if ($ledgerEntries->isNotEmpty()) {
                $firstEntry = $ledgerEntries->sortBy('id')->first();
                $lastEntry = $ledgerEntries->sortByDesc('id')->first();
                $totalBalance = $lastEntry ? $lastEntry->balance : 0;
                $startingBalance = $firstEntry ? $firstEntry->balance : $account->initial_balance;

                if ($firstEntry->entry_type == 'debit') {
                    $startingBalance -= $firstEntry->amount;
                } elseif ($firstEntry->entry_type == 'credit') {
                    $startingBalance += $firstEntry->amount;
                }
            } else {
                // Jika tidak ada entri, gunakan current_balance dari account
                $totalBalance = $account->current_balance;
                $startingBalance = $account->initial_balance;
            }

            $inCategories = Category::where(function ($query) use ($accountCode) {
                $query->whereHas('debitAccount', function ($subQuery) use ($accountCode) {
                    $subQuery->where('code', $accountCode);
                });
            })->orderBy('code', 'asc')->get();
            $outCategories = Category::where(function ($query) use ($accountCode) {
                $query->whereHas('creditAccount', function ($subQuery) use ($accountCode) {
                    $subQuery->where('code', $accountCode);
                });
            })->orderBy('code', 'asc')->get();

            $totalDebet = $ledgerEntries->where('entry_type', 'debit')->sum('amount');
            $totalCredit = $ledgerEntries->where('entry_type', 'credit')->sum('amount');
        } else {
            $ledgerEntries = $query->whereHas('account', function ($query) {
                $query->where('position', 'asset')->whereNotIn('code', ['101', '102']);
            })->get();

            $inCategories = Category::where(function ($query) {
                $query->whereHas('debitAccount', function ($subQuery) {
                    $subQuery->whereNotIn('code', ['101', '102']);
                });
            })->orderBy('code', 'asc')->get();

            $outCategories = Category::where(function ($query) {
                $query->whereHas('creditAccount', function ($subQuery) {
                    $subQuery->whereNotIn('code', ['101', '102']);
                });
            })->orderBy('code', 'asc')->get();

            $totalDebet = $ledgerEntries->where('entry_type', 'debit')->sum('amount');
            $totalCredit = $ledgerEntries->where('entry_type', 'credit')->sum('amount');
            $totalBalance = $totalDebet - $totalCredit;
        }
        $mutationCategories = Category::where('type', 'mutation')->orderBy('code', 'asc')->get();
        $startDateFormatted = Carbon::parse($startDate)->format('Y-m-d');
        $endDateFormatted = Carbon::parse($endDate)->format('Y-m-d');
        return view('transaction.index', compact('account', 'mutationCategories', 'inCategories', 'outCategories', 'totalBalance', 'startingBalance', 'startDateFormatted', 'endDateFormatted'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:255',
            'category_code' => 'required|exists:categories,code',
            'nominal' => 'required',
        ]);

        $category = Category::where('code', $request->category_code)->first();

        if (!$category) {
            return redirect()->back()->withErrors(['category_code' => 'Invalid category code.']);
        }

        if ($category->type === 'out' && !$request->filled('image')) {
            return redirect()->back()->withErrors(['image' => 'Foto nota wajib diisi untuk kategori ini.']);
        }

        $debetAccount = $category->debitAccount;
        $creditAccount = $category->creditAccount;

        $nominal = str_replace('.', '', $request->nominal);

        $transaction = $this->transactionModel->create([
            'transaction_at' => $request->tanggal ?? now(),
            'description' => $request->description,
            'category_code' => $request->category_code,
            'nominal' => $nominal,
            'user_id' => Auth::id(),
        ]);

        $currentMonth = $request->tanggal
            ? Carbon::parse($request->tanggal)->format('m-Y')
            : Carbon::now()->format('m-Y');

        $accounts = Account::all();
        foreach ($accounts as $account) {
            $existingMonthlyBalance = MonthlyBalance::where('account_code', $account->code)
                ->where('month', $currentMonth)
                ->first();

            if (!$existingMonthlyBalance) {
                $newMonthlyBalance = new MonthlyBalance();
                $newMonthlyBalance->account_code = $account->code;
                $newMonthlyBalance->month = $currentMonth;
                $newMonthlyBalance->balance = $account->current_balance;
                $newMonthlyBalance->save();
            }
        }

        if ($debetAccount) {
            if ($debetAccount->position == 'asset') {
                $debetAccount->current_balance += $nominal;
                $this->updateMonthlyBalance($debetAccount, $currentMonth, $nominal);
            } elseif ($debetAccount->position == 'liability') {
                $debetAccount->current_balance -= $nominal;
                $this->updateMonthlyBalance($debetAccount, $currentMonth, -$nominal);
            } else {
                $debetAccount->current_balance += $nominal;
                $this->updateMonthlyBalance($debetAccount, $currentMonth, $nominal);
                $this->updateRevenueAccount($nominal, $debetAccount->position, $currentMonth);
            }
            $debetAccount->save();

            LedgerEntry::create([
                'transaction_id' => $transaction->id,
                'account_code' => $debetAccount->code,
                'entry_date' => $transaction->transaction_at,
                'entry_type' => 'debit',
                'amount' => $nominal,
                'balance' => $debetAccount->current_balance,
            ]);
        }

        if ($creditAccount) {
            if ($creditAccount->position == 'asset') {
                $creditAccount->current_balance -= $nominal;
                $this->updateMonthlyBalance($creditAccount, $currentMonth, -$nominal);
            } elseif ($creditAccount->position == 'liability') {
                $creditAccount->current_balance += $nominal;
                $this->updateMonthlyBalance($creditAccount, $currentMonth, $nominal);
            } else {
                $creditAccount->current_balance += $nominal;
                $this->updateMonthlyBalance($creditAccount, $currentMonth, $nominal);
                $this->updateRevenueAccount($nominal, $creditAccount->position, $currentMonth);
            }
            $creditAccount->save();

            LedgerEntry::create([
                'transaction_id' => $transaction->id,
                'account_code' => $creditAccount->code,
                'entry_date' => $transaction->transaction_at,
                'entry_type' => 'credit',
                'amount' => $nominal,
                'balance' => $creditAccount->current_balance,
            ]);
        }

        $transactionId = $transaction->id;
        $img = $request->input('image');
        $filePath = null;

        if ($img) {
            $image_parts = explode(";base64,", $img);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $fileName = 'nota_' . time() . '.' . $image_type;
            $filePath = 'img/nota/' . $fileName;

            Storage::disk('public')->put($filePath, $image_base64);
            $noteTransaction = new NoteTransaction();
            $noteTransaction->transaction_id = $transactionId;
            $noteTransaction->img_src = $filePath;
            $noteTransaction->save();
        }


        $account_code = $request->account_code;
        if ($account_code) {
            return redirect()->route('transaction.index', ['account' => $account_code])->with('success', 'Transaction added successfully.');
        } else {
            return redirect()->route('transaction.index')->with('success', 'Transaction added successfully.');
        }
    }

    public function destroy($id)
    {
        $transaction = Transaction::find($id);
        if ($transaction) {
            $noteTransaction = $transaction->noteTransaction;
            if ($noteTransaction && $noteTransaction->img_src) {
                $filePath = 'public/' . $noteTransaction->img_src;
                if (Storage::exists($filePath)) {
                    Storage::delete($filePath);
                }
                $noteTransaction->delete();
            }

            $transaction->delete();
            return response()->json(['success' => 'Transaction deleted successfully']);
        }
        return response()->json(['error' => 'Transaction not found'], 404);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        try {
            $transactionMonth = $request->periode;
            $accounts = Account::all();

            foreach ($accounts as $account) {
                $existingMonthlyBalance = MonthlyBalance::where('account_code', $account->code)
                    ->where('month', $transactionMonth)
                    ->first();

                if (!$existingMonthlyBalance) {
                    $newMonthlyBalance = new MonthlyBalance();
                    $newMonthlyBalance->account_code = $account->code;
                    $newMonthlyBalance->month = $transactionMonth;
                    $newMonthlyBalance->balance = $account->current_balance;
                    $newMonthlyBalance->save();
                }
            }

            Excel::import(new TransactionsImport, $request->file('file'));
            return redirect()->back()->with('success', 'Accounts imported successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'There was an error importing the accounts: ' . $e->getMessage());
        }
    }

    private function updateMonthlyBalance(Account $account, $currentMonth, $nominal)
    {
        $monthlyBalance = MonthlyBalance::where('account_code', $account->code)
            ->where('month', $currentMonth)
            ->first();

        if ($monthlyBalance) {
            $monthlyBalance->balance += $nominal;
        } else {
            $previousMonth = Carbon::now()->subMonth()->format('m-Y');
            $previousMonthlyBalance = MonthlyBalance::where('account_code', $account->code)
                ->where('month', $previousMonth)
                ->first();

            if ($previousMonthlyBalance) {
                $initialBalance = $previousMonthlyBalance->balance;
            } else {
                $initialBalance = $account->initial_balance;
            }
            $monthlyBalance = new MonthlyBalance();
            $monthlyBalance->account_code = $account->code;
            $monthlyBalance->month = $currentMonth;
            $monthlyBalance->balance = $initialBalance + $nominal;
        }
        $monthlyBalance->save();
    }

    private function updateRevenueAccount($amount, $type, $currentMonth)
    {
        $revenueAccount = Account::where('code', '305')->first();

        if (!$revenueAccount) {
            return;
        }

        if ($type == 'revenue') {
            $revenueAccount->current_balance += $amount;
        } elseif ($type == 'expense') {
            $revenueAccount->current_balance -= $amount;
        }

        $revenueAccount->save();
        $this->updateMonthlyBalance($revenueAccount, $currentMonth, $amount * ($type == 'expense' ? -1 : 1));
    }
}
