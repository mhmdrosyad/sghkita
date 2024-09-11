<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use App\Models\MonthlyBalance;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        $foAccount = Account::where('code', '101')->first();
        $bcaAccount = Account::where('code', '102')->first();
        $bcaPayroll = Account::where('code', '103')->first();
        $foBalance = $foAccount->current_balance ?? 0;
        $bcaBalance = $bcaAccount->current_balance ?? 0;
        $bcaPayrollBalance = $bcaPayroll->current_balance ?? 0;

        $period = Carbon::now()->format('m-Y');

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

        $annualIncome = 0;
        $annualOutcome = 0;

        foreach ($accounts as $account) {
            // Hitung selisih current_balance dengan starting_balance untuk setiap akun
            $balanceDifference = $account->current_balance - $account->initial_balance;

            // Jika akun adalah revenue, tambahkan ke annualIncome
            if ($account->position == 'revenue') {
                $annualIncome += $balanceDifference;
            }
            // Jika akun adalah expense, tambahkan ke annualOutcome
            elseif ($account->position == 'expense') {
                $annualOutcome += $balanceDifference;
            }
        }

        // Hitung total laba tahunan
        $annualRevenue = $annualIncome - $annualOutcome;

        $totalRevenue = $totalIncome - $totalOutcome;


        return view('dashboard', compact('foBalance', 'bcaBalance', 'bcaPayrollBalance', 'totalRevenue', 'annualRevenue'));
    }
}
