<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Checkin;
use App\Models\Reservation;
use App\Models\Customer;
use App\Models\Invoice;

class CheckinController extends Controller
{
    public function index()
    {
        $checkins = Checkin::with('reservation')->get();
        // Jika Anda menggunakan relasi tambahan seperti customer, pastikan untuk menambahkannya
        $activeReservations = Reservation::where('status', 'active')->get();
        $customers = Customer::all();

        return view('checkin.index', compact('checkins', 'activeReservations', 'customers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'guest_name' => 'required|string',
            'pax' => 'required|integer',
            'room_charge' => 'required|numeric',
            'deposit' => 'required|numeric',
            'checkin_time' => 'required|date',
            'checkout_time' => 'required|date',
            'use_reservation' => 'required|string|in:yes,no',
            'order_code' => 'nullable|string',
        ]);

        $reservationCode = null;
        if ($request->input('use_reservation') === 'yes') {
            $reservation = Reservation::where('order_code', $request->input('order_code'))->first();
            if ($reservation) {
                $reservationCode = $reservation->order_code;
            } else {
                return redirect()->back()->withErrors(['order_code' => 'Invalid reservation code.']);
            }
        }

        // Simpan data checkin
        $checkin = Checkin::create([
            'reservation_code' => $reservationCode,
            'guest_name' => $request->input('guest_name'),
            'pax' => $request->input('pax'),
            'room_charge' => $request->input('room_charge'),
            'deposit' => $request->input('deposit'),
            'checkin_time' => $request->input('checkin_time'),
            'checkout_time' => $request->input('checkout_time'),
        ]);

        // Buat invoice jika tidak ada kode reservasi
        if (!$reservationCode) {
            Invoice::create([
                'reservation_code' => null, // Kolom ini diizinkan null setelah migration
                'description' => 'Invoice for walk-in guest: ' . $request->input('guest_name'),
                'user_id' => auth()->id(),
                'total_bill' => $request->input('room_charge') + $request->input('deposit'),
            ]);
        }

        return redirect()->route('checkins.index')->with('success', 'Check-in added successfully.');
    }



    public function destroy($id)
    {
        $checkin = Checkin::findOrFail($id);
        $checkin->delete();

        return redirect()->route('checkins.index')->with('success', 'Check-in deleted successfully.');
    }

    public function getReservationData(Request $request)
    {
        $orderCode = $request->query('order_code');
        $reservation = Reservation::where('order_code', $orderCode)->first();

        if (!$reservation) {
            return response()->json(['error' => 'Reservation not found.'], 404);
        }

        return response()->json([
            'guest_name' => $reservation->customer->name,
            'pax' => $reservation->pax,
            'room_charge' => $reservation->rate,
            'deposit' => $reservation->deposit,
            'checkin_time' => $reservation->checkin_time,
            'checkout_time' => $reservation->checkout_time,
        ]);
    }
}
