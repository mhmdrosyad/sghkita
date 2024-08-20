<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Checkin;
use App\Models\Reservation;

class CheckinController extends Controller
{
    public function index()
    {
        $checkins = Checkin::with('reservation')->where('status', 'checkin')->get();

        // Ambil kode reservasi yang sudah di-checkin
        $checkedInReservations = Checkin::pluck('reservation_code')->toArray();

        // Ambil reservasi aktif yang belum di-checkin
        $activeReservations = Reservation::where('status', 'active')
            ->whereNotIn('order_code', $checkedInReservations)
            ->get();

        // Ambil reservasi yang jatuh tempo dalam 3 hari ke depan dan belum di-checkin
        $upcomingReservations = Reservation::where('checkin', '>=', now()->startOfDay())
            ->where('checkin', '<=', now()->addDays(3)->endOfDay())
            ->where('status', 'active')
            ->whereNotIn('order_code', $checkedInReservations) // Tambahkan kondisi ini
            ->get();

        return view('checkin.index', compact('checkins', 'activeReservations', 'upcomingReservations'));
    }

    public function history()
    {
        // Ambil data check-ins dengan status 'checkout'
        $checkins = Checkin::where('status', 'checkout')->get();

        return view('checkin.history', compact('checkins'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'order_code' => 'required|string',
            'guest_name' => 'required|string',
            'instansi' => 'required|string',
            'total_tagihan' => 'required|numeric',
            'checkin_time' => 'required|date',
            'checkout_time' => 'nullable|date',
        ]);

        $reservation = Reservation::where('order_code', $request->input('order_code'))->first();

        if (!$reservation) {
            return redirect()->back()->withErrors(['order_code' => 'Invalid reservation code.']);
        }

        Checkin::create([
            'reservation_code' => $reservation->order_code,
            'guest_name' => $request->input('guest_name'),
            'instansi' => $request->input('instansi'),
            'total_tagihan' => $request->input('total_tagihan'),
            'checkin_time' => $request->input('checkin_time'),
            'checkout_time' => $request->input('checkout_time'),
            'status' => 'checkin', // Status default adalah checkin
        ]);

        return redirect()->route('checkins.index')->with('success', 'Check-in added successfully.');
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'checkin_id' => 'required|exists:checkins,id',
            'status' => 'required|in:checkin,checkout',
        ]);

        $checkin = Checkin::find($request->checkin_id);

        if ($request->status === 'checkout') {
            // Ambil reservasi terkait dari checkin
            $reservation = $checkin->reservation;

            // Ambil invoice terkait dari reservasi
            $invoice = $reservation->invoice;

            // Cek apakah status invoice adalah 'done'
            if (!$invoice || $invoice->status !== 'done') {
                return response()->json([
                    'success' => false,
                    'message' => 'Pembayaran belum selesai. Silakan selesaikan pembayaran terlebih dahulu.'
                ]);
            }

            // Jika pembayaran sudah selesai, set checkout time
            $checkin->checkout_time = now();
        }

        $checkin->status = $request->status;
        $checkin->save();

        return response()->json(['success' => true]);
    }


    public function getReservationData(Request $request)
    {
        $orderCode = $request->get('order_code');

        $reservation = Reservation::where('order_code', $orderCode)
            ->with('customer', 'invoice')
            ->first();

        if (!$reservation) {
            return response()->json(['error' => 'Reservation not found'], 404);
        }

        $data = [
            'guest_name' => $reservation->customer->name,
            'instansi' => $reservation->customer->agency,
            'total_tagihan' => $reservation->invoice ? $reservation->invoice->total_bill : 0,
            'checkin_time' => $reservation->checkin_time ? $reservation->checkin_time->format('Y-m-d\TH:i') : '',
            'checkout_time' => $reservation->checkout_time ? $reservation->checkout_time->format('Y-m-d\TH:i') : '',
        ];

        return response()->json($data);
    }
}
