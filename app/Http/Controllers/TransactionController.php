<?php

namespace App\Http\Controllers;

use App\Imports\TransactionsImport;
use App\Models\Account;
use App\Models\Category;
use App\Models\LedgerEntry;
use App\Models\MonthlyBalance;
use Illuminate\Http\Request;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
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
                    $query->where('position', 'asset')->whereNotIn('code', ['101', '102']);
                });
            }


            return DataTables::of($query)
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
                ->addColumn('action', function ($entry) {
                    return '<div class="action">
                                <button class="text-danger delete-button" data-id="' . $entry->transaction->id . '">
                                    <i class="lni lni-trash-can"></i>
                                </button>
                            </div>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }


        $account = Account::find($accountCode);
        $inCategories = null;
        $outCategories = null;

        $query = LedgerEntry::whereBetween('entry_date', [$startDate, $endDate]);
        if ($account) {
            $ledgerEntries = $query->where('account_code', $accountCode)->get();

            $inCategories = Category::where(function ($query) use ($accountCode) {
                $query->whereHas('debitAccount', function ($subQuery) use ($accountCode) {
                    $subQuery->where('code', $accountCode);
                });
            })->get();
            $outCategories = Category::where(function ($query) use ($accountCode) {
                $query->whereHas('creditAccount', function ($subQuery) use ($accountCode) {
                    $subQuery->where('code', $accountCode);
                });
            })->get();

            $totalDebet = $ledgerEntries->where('entry_type', 'debit')->sum('amount');
            $totalCredit = $ledgerEntries->where('entry_type', 'credit')->sum('amount');

            $totalBalance = $account->current_balance;
        } else {
            $ledgerEntries = $query->whereHas('account', function ($query) {
                $query->where('position', 'asset')->whereNotIn('code', ['101', '102']);
            })->get();

            $inCategories = Category::where(function ($query) {
                $query->whereHas('debitAccount', function ($subQuery) {
                    $subQuery->whereNotIn('code', ['101', '102']);
                });
            })->get();

            $outCategories = Category::where(function ($query) {
                $query->whereHas('creditAccount', function ($subQuery) {
                    $subQuery->whereNotIn('code', ['101', '102']);
                });
            })->get();

            $totalDebet = $ledgerEntries->where('entry_type', 'debit')->sum('amount');
            $totalCredit = $ledgerEntries->where('entry_type', 'credit')->sum('amount');
            $totalBalance = $totalDebet - $totalCredit;
        }
        $mutationCategories = Category::where('type', 'mutation')->get();
        $startDateFormatted = Carbon::parse($startDate)->format('Y-m-d');
        $endDateFormatted = Carbon::parse($endDate)->format('Y-m-d');
        return view('transaction.index', compact('account', 'mutationCategories', 'inCategories', 'outCategories', 'totalBalance', 'startDateFormatted', 'endDateFormatted'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:255',
            'category_code' => 'required|exists:categories,code',
            'nominal' => 'required|numeric|min:0',
        ]);

        $category = Category::where('code', $request->category_code)->first();

        if (!$category) {
            return redirect()->back()->withErrors(['category_code' => 'Invalid category code.']);
        }

        $debetAccount = $category->debitAccount;
        $creditAccount = $category->creditAccount;

        $transaction = $this->transactionModel->create([
            'transaction_at' => now(),
            'description' => $request->description,
            'category_code' => $request->category_code,
            'nominal' => $request->nominal,
            'user_id' => Auth::id(),
        ]);

        $currentMonth = Carbon::now()->format('m-Y');

        if ($debetAccount) {
            if ($debetAccount->position == 'asset') {
                $debetAccount->current_balance += $request->nominal;
                $this->updateMonthlyBalance($debetAccount, $currentMonth, $request->nominal);
            } elseif ($debetAccount->position == 'liability') {
                $debetAccount->current_balance -= $request->nominal;
                $this->updateMonthlyBalance($debetAccount, $currentMonth, -$request->nominal);
            } else {
                $debetAccount->current_balance += $request->nominal;
                $this->updateMonthlyBalance($debetAccount, $currentMonth, $request->nominal);
                $this->updateRevenueAccount($request->nominal, $debetAccount->position, $currentMonth);
            }
            $debetAccount->save();

            LedgerEntry::create([
                'transaction_id' => $transaction->id,
                'account_code' => $debetAccount->code,
                'entry_date' => $transaction->transaction_at,
                'entry_type' => 'debit',
                'amount' => $request->nominal,
            ]);
        }

        if ($creditAccount) {
            if ($creditAccount->position == 'asset') {
                $creditAccount->current_balance -= $request->nominal;
                $this->updateMonthlyBalance($creditAccount, $currentMonth, -$request->nominal);
            } elseif ($creditAccount->position == 'liability') {
                $creditAccount->current_balance += $request->nominal;
                $this->updateMonthlyBalance($creditAccount, $currentMonth, $request->nominal);
            } else {
                $creditAccount->current_balance += $request->nominal;
                $this->updateMonthlyBalance($creditAccount, $currentMonth, $request->nominal);
                $this->updateRevenueAccount($request->nominal, $creditAccount->position, $currentMonth);
            }
            $creditAccount->save();

            LedgerEntry::create([
                'transaction_id' => $transaction->id,
                'account_code' => $creditAccount->code,
                'entry_date' => $transaction->transaction_at,
                'entry_type' => 'credit',
                'amount' => $request->nominal,
            ]);
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
