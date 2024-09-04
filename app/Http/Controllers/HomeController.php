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
        $foBalance = $foAccount->current_balance ?? 0;
        $bcaBalance = $bcaAccount->current_balance ?? 0;
        $bcaPayrollBalance = $bcaPayroll->current_balance ?? 0;
        return view('dashboard', compact('foBalance', 'bcaBalance', 'bcaPayrollBalance'));
    }
}
