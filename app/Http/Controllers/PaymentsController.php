<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Transaction;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{
    public function store(Request $request)
    {
        // Validasi data request
        $validated = $request->validate([
            'reservation_code' => 'required|string',
            'type' => 'required|in:deposit,pelunasan',
            'total' => 'required|numeric|min:0',
            'category_code' => 'required|string', // Validasi untuk kode kategori
        ]);

        // Verifikasi apakah category_code valid
        $categoryCodeExists = \DB::table('categories')->where('code', $validated['category_code'])->exists();

        if (!$categoryCodeExists) {
            return redirect()->back()->withErrors(['category_code' => 'Kode kategori tidak valid.']);
        }

        // Buat transaksi baru
        $transaction = Transaction::create([
            'transaction_at' => now(),
            'description' => $validated['type'] . ' (Order Code: ' . $validated['reservation_code'] . ') - Total Amount: ' . number_format($validated['total'], 2),
            'category_code' => $validated['category_code'],
            'nominal' => $validated['total'],
            'user_id' => auth()->id(), // ID pengguna yang sedang login
        ]);

        // Buat entri pembayaran dengan ID transaksi yang baru dibuat
        Payment::create([
            'reservation_code' => $validated['reservation_code'],
            'type' => $validated['type'],
            'transaction_id' => $transaction->id, // Hubungkan dengan transaksi yang baru dibuat
        ]);

        return redirect()->back()->with('success', 'Pembayaran berhasil dicatat.');
    }
}
