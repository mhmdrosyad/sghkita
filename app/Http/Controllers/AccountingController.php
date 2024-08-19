<?php

namespace App\Http\Controllers;

use App\Imports\MonthlyBalanceImport;
use App\Models\Account;
use App\Models\MonthlyBalance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AccountingController extends Controller
{
    public function balanceSheet(Request $request)
    {
        $period = $request->query('period', Carbon::now()->format('m-Y'));

        if (!preg_match('/^\d{2}-\d{4}$/', $period)) {
            abort(400, 'Invalid period format. Use mm-yyyy.');
        }

        $periods = MonthlyBalance::select('month')->distinct()->orderBy('month', 'desc')->get();
        $accounts = Account::all();
        $monthlyBalances = MonthlyBalance::where('month', $period)->get()->keyBy('account_code');

        $activaAccounts = [];
        $passivaAccounts = [];
        $totalActiva = 0;
        $totalPassiva = 0;

        foreach ($accounts as $account) {
            $balance = $monthlyBalances->get($account->code);
            $accountBalance = $balance ? $balance->balance : $account->current_balance;

            if ($account->position == 'asset') {
                $activaAccounts[] = [
                    'account' => $account,
                    'balance' => $accountBalance
                ];
                $totalActiva += $accountBalance;
            } elseif ($account->position == 'liability') {
                $passivaAccounts[] = [
                    'account' => $account,
                    'balance' => $accountBalance
                ];
                $totalPassiva += $accountBalance;
            }
        }

        return view('accounting.balance_sheet', compact('periods', 'period', 'activaAccounts', 'passivaAccounts', 'totalActiva', 'totalPassiva'));
    }
    public function profitLoss(Request $request)
    {
        $period = $request->query('period', Carbon::now()->format('m-Y'));

        if (!preg_match('/^\d{2}-\d{4}$/', $period)) {
            abort(400, 'Invalid period format. Use mm-yyyy.');
        }

        $periods = MonthlyBalance::select('month')->distinct()->orderBy('month', 'desc')->get();
        $accounts = Account::all();
        $monthlyBalances = MonthlyBalance::where('month', $period)->get()->keyBy('account_code');

        $incomeAccounts = [];
        $outcomeAccounts = [];
        $totalIncome = 0;
        $totalOutcome = 0;

        foreach ($accounts as $account) {
            $balance = $monthlyBalances->get($account->code);
            $accountBalance = $balance ? $balance->balance : 0;

            if ($account->position == 'revenue') {
                $incomeAccounts[] = [
                    'account' => $account,
                    'balance' => $accountBalance
                ];
                $totalIncome += $accountBalance;
            } elseif ($account->position == 'expense') {
                $outcomeAccounts[] = [
                    'account' => $account,
                    'balance' => $accountBalance
                ];
                $totalOutcome += $accountBalance;
            }
        }

        return view('accounting.profit_loss', compact('periods', 'period', 'incomeAccounts', 'outcomeAccounts', 'totalIncome', 'totalOutcome'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
            'month' => 'required|date_format:m-Y',
        ]);

        $month = $request->input('month');

        try {
            Excel::import(new MonthlyBalanceImport($month), $request->file('file'));
            return redirect()->back()->with('success', 'Accounts imported successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'There was an error importing the accounts: ' . $e->getMessage());
        }
    }
}
