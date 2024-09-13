<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;


class InvoiceController extends Controller
{
    // Display a listing of the invoices
    public function index()
    {
        // Fetch all invoices with related reservation and user data
        $invoices = Invoice::with('reservation', 'user')->get();
        return view('invoices.index', compact('invoices'));
    }

    public function show($id)
    {
        // Fetch the invoice with related reservation, user, items, and payments data
        $invoice = Invoice::with(['reservation', 'user', 'items', 'payments'])->findOrFail($id);

        // Calculate the total deposit from the payments related to the invoice's reservation
        $totalDeposit = $invoice->payments->where('type', 'deposit')->sum('total');

        // Pass the invoice and total deposit to the view
        return view('invoices.show', compact('invoice', 'totalDeposit'));
    }

    // Add new item to the invoice
    public function addItem(Request $request, $id)
    {
        // Validate input
        $validatedData = $request->validate([
            'description' => 'required|string|max:255',
            'rate' => 'required|numeric',
            'pax' => 'required|integer',
        ]);

        // Find the invoice by ID
        $invoice = Invoice::findOrFail($id);

        // Add new item
        $item = new InvoiceItem([
            'invoice_id' => $invoice->id,
            'description' => $validatedData['description'],
            'rate' => $validatedData['rate'],
            'pax' => $validatedData['pax'],
            'total' => $validatedData['rate'] * $validatedData['pax'],
        ]);

        // Save the new item
        $item->save();

        // Update total bill in the invoice
        $totalBill = $invoice->items->sum(function ($item) {
            return $item->rate * $item->pax;
        }) + ($invoice->reservation->rate * $invoice->reservation->pax);

        $invoice->total_bill = $totalBill;
        $invoice->save();

        // Redirect to the invoice page with a success message
        return redirect()->route('invoices.show', $invoice->id)
            ->with('success', 'Item berhasil ditambahkan.');
    }

    // Edit an item in the invoice
    public function editItem(Request $request, $invoiceId, $itemId)
    {
        // Validasi input
        $validatedData = $request->validate([
            'description' => 'required|string|max:255',
            'rate' => 'required|numeric',
            'pax' => 'required|integer',
        ]);

        // Temukan item berdasarkan ID
        $item = InvoiceItem::where('id', $itemId)->where('invoice_id', $invoiceId)->firstOrFail();

        // Perbarui item
        $item->update([
            'description' => $validatedData['description'],
            'rate' => $validatedData['rate'],
            'pax' => $validatedData['pax'],
            'total' => $validatedData['rate'] * $validatedData['pax'],
        ]);

        // Temukan invoice terkait dengan item
        $invoice = $item->invoice;

        // Perbarui total bill di invoice
        $totalBill = $invoice->items->sum(function ($item) {
            return $item->rate * $item->pax;
        }) + ($invoice->reservation->rate * $invoice->reservation->pax);

        $invoice->total_bill = $totalBill;
        $invoice->save();

        // Redirect ke halaman invoice dengan pesan sukses
        return redirect()->route('invoices.show', $invoice->id)
            ->with('success', 'Item berhasil diperbarui.');
    }


    // Delete an item from the invoice
    public function deleteItem($invoiceId, $itemId)
    {
        // Temukan item berdasarkan ID
        $item = InvoiceItem::where('id', $itemId)->where('invoice_id', $invoiceId)->firstOrFail();

        // Temukan invoice terkait dengan item
        $invoice = $item->invoice;

        // Hapus item
        $item->delete();

        // Perbarui total bill di invoice
        $totalBill = $invoice->items->sum(function ($item) {
            return $item->rate * $item->pax;
        }) + ($invoice->reservation->rate * $invoice->reservation->pax);

        $invoice->total_bill = $totalBill;
        $invoice->save();

        // Redirect ke halaman invoice dengan pesan sukses
        return redirect()->route('invoices.show', $invoice->id)
            ->with('success', 'Item berhasil dihapus.');
    }

    public function generatePDF(Invoice $invoice)
    {
        // Ambil data invoice seperti di tampilan biasa
        $data = [
            'invoice' => $invoice,
            // Data tambahan jika diperlukan
        ];

        // Load tampilan Blade dan buat PDF
        $pdf = Pdf::loadView('invoices.pdf', $data);

        // Kembalikan respon download PDF
        return $pdf->download('invoice_' . $invoice->reservation->order_code . '.pdf');
    }
}
