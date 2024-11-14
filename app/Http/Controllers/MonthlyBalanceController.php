<?php

namespace App\Http\Controllers;

use App\Models\MonthlyBalance;
use Illuminate\Http\Request;

class MonthlyBalanceController extends Controller
{
    public function index()
    {
        $months = MonthlyBalance::select('month')
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        return view('monthly_balance.index', compact('months'));
    }

    public function destroy($month)
    {
        MonthlyBalance::where('month', $month)->delete();
        return redirect()->route('monthly_balance.index')
            ->with('success', 'All data for ' . $month . ' has been deleted.');
    }
}
