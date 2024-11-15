<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Category;
use App\Models\Kasbon;
use App\Models\LedgerEntry;
use App\Models\MonthlyBalance;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KasbonController extends Controller
{
    public function index()
    {
        $kasbons = Kasbon::where('is_paid', false)->get();
        return view('kasbon.index', compact('kasbons'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'tgl_pinjam' => 'required|date',
            'nama' => 'required|string|max:255',
            'nominal' => 'required',
            'keterangan' => 'required|string',
            'tipe' => 'required|in:pribadi,operasional',
        ]);

        Kasbon::create([
            'tgl_pinjam' => $validatedData['tgl_pinjam'],
            'nama' => $validatedData['nama'],
            'nominal' => $validatedData['nominal'],
            'keterangan' => $validatedData['keterangan'],
            'user_id' => Auth::id(),
            'is_paid' => false,
            'tipe' => $validatedData['tipe'],
        ]);
        return redirect()->back()->with('success', 'Kasbon baru berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $kasbon = Kasbon::findOrFail($id);
        $kasbon->delete();
        return redirect()->route('kasbon.index')->with('success', 'Kasbon deleted successfully');
    }

    public function toggleStatus($id)
    {
        $kasbon = Kasbon::findOrFail($id);
        $kasbon->is_paid = !$kasbon->is_paid;
        if ($kasbon->is_paid) {
            $kasbon->tgl_kembali = Carbon::now();
        } else {
            $kasbon->tgl_kembali = null;
        }
        $kasbon->save();
        return redirect()->back()->with('success', 'Status kasbon berhasil diubah!');
    }

    public function payroll($id, Request $request)
    {
        $transactionModel = new Transaction();
        $jumlahPembayaran = $request->input('nominal');
        $kasbon = Kasbon::findOrFail($id);
        $kasbon->tgl_kembali = Carbon::now();
        if (!$kasbon->nominal_kembali) {
            $kasbon->nominal_kembali = 0;
        }
        $kasbon->nominal_kembali += $jumlahPembayaran;

        if ($kasbon->nominal_kembali > $kasbon->nominal) {
            return redirect()->back()->with('error', 'Jumlah pembayaran melebihi nominal kasbon.');
        }
        if ($kasbon->nominal_kembali >= $kasbon->nominal) {
            $kasbon->is_paid = true;
        }

        $category = Category::where('code', '078')->first();

        if (!$category) {
            return redirect()->back()->withErrors(['category_code' => 'Invalid category code.']);
        }

        $debetAccount = $category->debitAccount;
        $creditAccount = $category->creditAccount;

        $nominal = $jumlahPembayaran;

        $transaction = $transactionModel->create([
            'transaction_at' => $request->tanggal ?? now(),
            'description' => 'Pembayaran kasbon a.n ' . $kasbon->nama . ' (' . $kasbon->tgl_pinjam . ')',
            'category_code' => '078',
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


        $kasbon->save();
        return redirect()->back()->with('success', 'Pembayaran kasbon payroll sudah berhasil!');
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
