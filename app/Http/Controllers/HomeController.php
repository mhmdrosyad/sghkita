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

        $periodNow = Carbon::now()->format('m-Y');
        $periodPrevious = Carbon::now()->subMonth()->format('m-Y');

        $accounts = Account::all();

        $monthlyBalancesNow = MonthlyBalance::where('month', $periodNow)->get()->keyBy('account_code');
        $monthlyBalancesPrevious = MonthlyBalance::where('month', $periodPrevious)->get()->keyBy('account_code');

        $incomeAccounts = [];
        $outcomeAccounts = [];
        $totalIncome = 0;
        $totalOutcome = 0;
        $totalIncomeDifference = 0;
        $totalOutcomeDifference = 0;


        foreach ($accounts as $account) {
            // Ambil balance bulan sekarang
            $balanceNow = $monthlyBalancesNow->get($account->code);
            $accountBalanceNow = $balanceNow ? $balanceNow->balance : 0;

            // Ambil balance bulan sebelumnya sebagai saldo awal bulan ini
            $balancePrevious = $monthlyBalancesPrevious->get($account->code);
            $accountBalancePrevious = $balancePrevious ? $balancePrevious->balance : 0;

            // Hitung selisih balance (pendapatan/pengeluaran bulan ini)
            $balanceDifference = $accountBalanceNow - $accountBalancePrevious;

            if ($account->position == 'revenue') {
                $incomeAccounts[] = [
                    'account' => $account,
                    'balance' => $accountBalanceNow,
                    'difference' => $balanceDifference // Pendapatan bulan ini
                ];
                $totalIncome += $accountBalanceNow;
                $totalIncomeDifference += $balanceDifference;
            } elseif ($account->position == 'expense') {
                $outcomeAccounts[] = [
                    'account' => $account,
                    'balance' => $accountBalanceNow,
                    'difference' => $balanceDifference // Pengeluaran bulan ini
                ];
                $totalOutcome += $accountBalanceNow;
                $totalOutcomeDifference += $balanceDifference;
            }
        }


        $annualIncome = 0;
        $annualOutcome = 0;

        foreach ($accounts as $account) {
            $balanceDifference = $account->current_balance - $account->initial_balance;

            if ($account->position == 'revenue') {
                $annualIncome += $balanceDifference;
            } elseif ($account->position == 'expense') {
                $annualOutcome += $balanceDifference;
            }
        }

        $annualRevenue = $annualIncome - $annualOutcome;
        $totalRevenue = $totalIncome - $totalOutcome;
        $totalRevenueDifference = $totalIncomeDifference - $totalOutcomeDifference;


        return view('dashboard', compact('foBalance', 'bcaBalance', 'bcaPayrollBalance', 'totalRevenueDifference', 'annualRevenue'));
    }
}
