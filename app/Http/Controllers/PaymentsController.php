<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Reservation;
use App\Models\Transaction;
use App\Models\LedgerEntry;
use App\Models\Category;
use App\Models\Invoice;
use App\Models\Account;
use App\Models\MonthlyBalance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PaymentsController extends Controller
{
    public function store(Request $request)
    {
        // Validasi data request
        $validated = $request->validate([
            'reservation_code' => 'required|string',
            'type' => 'required|in:008,064',
            'total' => 'required|numeric|min:0',
        ]);

        // Verifikasi apakah type valid dan tentukan account_code
        $category = Category::where('code', $validated['type'])->first();
        if (!$category) {
            return redirect()->back()->withErrors(['type' => 'Kode kategori tidak valid.']);
        }

        // Dapatkan akun terkait dengan kategori
        $debetAccount = $category->debitAccount;
        $creditAccount = $category->creditAccount;

        if (!$debetAccount && !$creditAccount) {
            return redirect()->back()->withErrors(['type' => 'Akun terkait tidak ditemukan.']);
        }

        // Buat transaksi baru
        $transaction = Transaction::create([
            'transaction_at' => now(),
            'description' => ($validated['type'] == '008' ? 'Deposit Tamu Grup' : 'Deposit Tamu via BCA') . ' (Kode Pesanan: ' . $validated['reservation_code'] . ') - Jumlah Total: ' . number_format($validated['total'], 2),
            'category_code' => $validated['type'],
            'nominal' => $validated['total'],
            'user_id' => Auth::id(),
        ]);

        // Buat entri pembayaran dengan ID transaksi yang baru dibuat
        $payment = Payment::create([
            'reservation_code' => $validated['reservation_code'],
            'type' => ($validated['type'] == '008' ? 'deposit' : 'pelunasan'),
            'transaction_id' => $transaction->id,
        ]);

        $totalAmount = $validated['total'];

        // Update akun debit jika ada
        if ($debetAccount) {
            $this->updateAccountBalance($debetAccount, $totalAmount, 'debit', $transaction);
        }

        // Update akun kredit jika ada
        if ($creditAccount) {
            $this->updateAccountBalance($creditAccount, $totalAmount, 'credit', $transaction);
        }

        // Perbarui status reservasi menjadi 'active' jika pembayaran berhasil
        $reservation = Reservation::where('order_code', $validated['reservation_code'])->first();
        if ($reservation && $reservation->status == 'waiting_list') {
            $reservation->update(['status' => 'active']);
        }

        // Perbarui status invoice menjadi 'dp' atau 'done'
        $invoice = Invoice::where('reservation_code', $validated['reservation_code'])->first();
        if ($invoice) {
            // Hitung total pembayaran untuk reservasi ini dengan join ke tabel transactions
            $totalPayments = $invoice->payments()->join('transactions', 'payments.transaction_id', '=', 'transactions.id')
                ->sum('transactions.nominal');

            if ($totalPayments >= $invoice->total_bill) {
                // Jika total pembayaran >= total tagihan, perbarui status menjadi 'done'
                $invoice->update(['status' => 'done']);

                // Rekam transaksi sebagai Pendapatan Tamu Group
                $this->recordGuestGroupIncome($invoice);
            } else {
                // Jika belum lunas, status tetap 'dp'
                $invoice->update(['status' => 'dp']);
            }
        }

        return redirect()->back()->with('success', 'Pembayaran berhasil dicatat.');
    }

    private function updateAccountBalance($account, $amount, $entryType, $transaction)
    {
        if ($entryType == 'debit') {
            $account->current_balance += $amount;
        } elseif ($entryType == 'credit') {
            $account->current_balance += $amount;
        }

        $account->save();

        // Buat entri ledger untuk akun yang diperbarui
        LedgerEntry::create([
            'transaction_id' => $transaction->id,
            'account_code' => $account->code,
            'entry_date' => $transaction->transaction_at->format('Y-m-d'),
            'entry_type' => $entryType,
            'amount' => $amount,
            'balance' => $account->current_balance
        ]);

        // Perbarui saldo bulanan untuk akun
        $this->updateMonthlyBalance($account->code, $transaction->transaction_at, $amount, $entryType);
    }

    private function updateMonthlyBalance($accountCode, $transactionDate, $amount, $entryType)
    {
        $transactionDate = Carbon::parse($transactionDate);
        $month = $transactionDate->format('m-Y');

        $monthlyBalance = MonthlyBalance::firstOrNew([
            'account_code' => $accountCode,
            'month' => $month,
        ]);

        // Sesuaikan logika saldo untuk memastikan saldo tidak menjadi negatif
        if ($entryType == 'debit') {
            $monthlyBalance->balance += $amount;
        } elseif ($entryType == 'credit') {
            $monthlyBalance->balance += $amount;
        }

        $monthlyBalance->balance = max($monthlyBalance->balance, 0); // Pastikan saldo tidak negatif

        $monthlyBalance->save();
    }

    private function recordGuestGroupIncome(Invoice $invoice)
    {
        // Cari kategori Pendapatan Tamu Group dengan kode 108
        $category = Category::where('code', '108')->first();

        if (!$category) {
            // Jika kategori tidak ditemukan, keluar dari fungsi
            return;
        }

        // Buat transaksi baru untuk Pendapatan Tamu Group
        $transaction = Transaction::create([
            'transaction_at' => now(),
            'description' => 'Pendapatan Tamu Group untuk Invoice: ' . $invoice->id,
            'category_code' => $category->code,
            'nominal' => $invoice->total_bill,
            'user_id' => Auth::id(),
        ]);

        // Dapatkan akun debit dan kredit terkait dengan kategori ini
        $debetAccount = $category->debitAccount;
        $creditAccount = $category->creditAccount;

        // Update akun debit jika ada
        if ($debetAccount) {
            $this->updateAccountBalance($debetAccount, $invoice->total_bill, 'debit', $transaction);
        }

        // Update akun kredit jika ada
        if ($creditAccount) {
            $this->updateAccountBalance($creditAccount, $invoice->total_bill, 'credit', $transaction);
        }
    }
}
