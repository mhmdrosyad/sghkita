<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Reservation;
use App\Models\Transaction;
use App\Models\LedgerEntry;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        // Verifikasi apakah category_code valid
        $category = Category::where('code', $validated['type'])->first();

        if (!$category) {
            return redirect()->back()->withErrors(['category_code' => 'Kode kategori tidak valid.']);
        }

        $debetAccount = $category->debitAccount;
        $creditAccount = $category->creditAccount;

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
            'type' => $validated['type'] == '008' ? 'deposit' : 'pelunasan',
            'transaction_id' => $transaction->id,
        ]);

        // Buat entri buku besar
        if ($debetAccount) {
            LedgerEntry::create([
                'transaction_id' => $transaction->id,
                'account_code' => $debetAccount->code,
                'entry_date' => $transaction->transaction_at,
                'entry_type' => 'debit',
                'amount' => $validated['total'],
            ]);
        }

        if ($creditAccount) {
            LedgerEntry::create([
                'transaction_id' => $transaction->id,
                'account_code' => $creditAccount->code,
                'entry_date' => $transaction->transaction_at,
                'entry_type' => 'credit',
                'amount' => $validated['total'],
            ]);
        }

        // Perbarui status reservasi menjadi 'active' jika pembayaran berhasil
        if ($payment) {
            $reservation = Reservation::where('order_code', $validated['reservation_code'])->first();
            if ($reservation && $reservation->status == 'waiting_list') {
                $reservation->update(['status' => 'active']);
            }
        }

        return redirect()->back()->with('success', 'Pembayaran berhasil dicatat.');
    }
}
