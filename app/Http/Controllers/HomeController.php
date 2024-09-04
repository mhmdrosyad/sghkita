<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $foAccount = Account::where('code', '101')->first();
        $bcaAccount = Account::where('code', '102')->first();
        $bcaPayroll = Account::where('code', '103')->first();
        $foBalance = $foAccount->current_balance;
        $bcaBalance = $bcaAccount->current_balance;
        $bcaPayrollBalance = $bcaPayroll->current_balance;
        return view('dashboard', compact('foBalance', 'bcaBalance', 'bcaPayrollBalance'));
    }
}
