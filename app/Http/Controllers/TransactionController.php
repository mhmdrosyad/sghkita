<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Category;
use App\Models\MonthlyBalance;
use Illuminate\Http\Request;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

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
        $account = Account::find($accountCode);
        $inCategories = null;
        $outCategories = null;
        if ($account) {
            $transactions = Transaction::whereHas('category.debetAccount', function ($query) use ($accountCode) {
                $query->where('code', $accountCode);
            })->orWhereHas('category.creditAccount', function ($query) use ($accountCode) {
                $query->where('code', $accountCode);
            })->get();

            $inCategories = Category::where(function ($query) use ($accountCode) {
                $query->whereHas('debetAccount', function ($subQuery) use ($accountCode) {
                    $subQuery->where('code', $accountCode);
                });
            })->get();
            $outCategories = Category::where(function ($query) use ($accountCode) {
                $query->whereHas('creditAccount', function ($subQuery) use ($accountCode) {
                    $subQuery->where('code', $accountCode);
                });
            })->get();

            $totalDebet = 0;
            $totalCredit = 0;

            foreach ($transactions as $transaction) {
                if ($transaction->category->debetAccount->code == $accountCode) {
                    $totalDebet += $transaction->nominal;
                } elseif ($transaction->category->creditAccount->code == $accountCode) {
                    $totalCredit += $transaction->nominal;
                }
            }

            $totalBalance = $account->current_balance;
        } else {
            $transactions = Transaction::whereHas('category.debetAccount', function ($query) {
                $query->whereNotIn('code', ['101', '102']);
            })->orWhereHas('category.creditAccount', function ($query) {
                $query->whereNotIn('code', ['101', '102']);
            })->get();

            $inCategories = Category::where(function ($query) {
                $query->whereHas('debetAccount', function ($subQuery) {
                    $subQuery->whereNotIn('code', ['101', '102']);
                });
            })->get();

            $outCategories = Category::where(function ($query) {
                $query->whereHas('creditAccount', function ($subQuery) {
                    $subQuery->whereNotIn('code', ['101', '102']);
                });
            })->get();

            $totalDebet = 0;
            $totalCredit = 0;

            foreach ($transactions as $transaction) {
                if ($transaction->category->debetAccount->code == $accountCode) {
                    $totalDebet += $transaction->nominal;
                } elseif ($transaction->category->creditAccount->code == $accountCode) {
                    $totalCredit += $transaction->nominal;
                }
            }
            $totalBalance = $totalDebet - $totalCredit;
        }
        $mutationCategories = Category::where('type', 'mutation')->get();
        return view('transaction.index', compact('account', 'mutationCategories', 'inCategories', 'outCategories', 'transactions', 'totalBalance'));
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

        $debetAccount = $category->debetAccount;
        $creditAccount = $category->creditAccount;

        $this->transactionModel->create([
            'transaction_at' => now(),
            'description' => $request->description,
            'category_code' => $request->category_code,
            'nominal' => $request->nominal,
            'user_id' => Auth::id(),
        ]);

        $currentMonth = Carbon::now()->format('m-Y');

        if ($debetAccount) {
            if ($debetAccount->position == 'activa') {
                $debetAccount->current_balance += $request->nominal;
                $this->updateMonthlyBalance($debetAccount, $currentMonth, $request->nominal);
            } elseif ($debetAccount->position == 'passiva') {
                $debetAccount->current_balance -= $request->nominal;
                $this->updateMonthlyBalance($debetAccount, $currentMonth, -$request->nominal);
            } else {
                $debetAccount->current_balance += $request->nominal;
                $this->updateMonthlyBalance($debetAccount, $currentMonth, $request->nominal);
            }
            $debetAccount->save();
        }

        if ($creditAccount) {
            if ($creditAccount->position == 'activa') {
                $creditAccount->current_balance -= $request->nominal;
                $this->updateMonthlyBalance($creditAccount, $currentMonth, -$request->nominal);
            } elseif ($creditAccount->position == 'passiva') {
                $creditAccount->current_balance += $request->nominal;
                $this->updateMonthlyBalance($creditAccount, $currentMonth, $request->nominal);
            } else {
                $creditAccount->current_balance += $request->nominal;
                $this->updateMonthlyBalance($creditAccount, $currentMonth, $request->nominal);
            }
            $creditAccount->save();
        }

        $account_code = $request->account_code;
        if ($account_code) {
            return redirect()->route('transaction.index', ['account' => $account_code])->with('success', 'Transaction added successfully.');
        } else {
            return redirect()->route('transaction.index')->with('success', 'Transaction added successfully.');
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
}
