<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Customer;
use App\Models\ResCategory;
use App\Models\Sales;
use App\Models\Invoice;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index()
    {
        $activeReservations = Reservation::where('status', 'active')
            ->with(['customer', 'resCategory', 'user', 'sales', 'invoice']) // Include invoice if related
            ->get();

        $waitingListReservations = Reservation::where('status', 'waiting_list')
            ->with(['customer', 'resCategory', 'user', 'sales', 'invoice']) // Include invoice if related
            ->get();
        $resCategories = ResCategory::all();
        $customers = Customer::all();
        $sales = Sales::all();
        $invoices = Invoice::all();

        return view('reservation.index', [
            'activeReservations' => $activeReservations,
            'waitingListReservations' => $waitingListReservations,
            'resCategories' => $resCategories,
            'customers' => $customers,
            'sales' => $sales,
            'invoices' => $invoices,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'checkin' => 'required|date',
            'checkout' => 'required|date',
            'res_category_id' => 'required|exists:res_categories,id_rescategory',
            'pax' => 'required|integer',
            'rate' => 'required|numeric',
            'note' => 'nullable|string',
            'id_sp' => 'nullable|exists:sales,id',
        ]);
        $orderCode = $this->generateUniqueOrderCode();

        // Prepare data
        $data = $request->all();
        $data['order_code'] = $orderCode;
        $data['user_id'] = auth()->id();
        $data['status'] = $data['status'] ?? 'waiting_list';

        $reservation = Reservation::create($data);

        // Create an invoice for the reservation
        Invoice::create([
            'reservation_code' => $orderCode,
            'description' => 'Invoice for reservation ' . $orderCode,
            'user_id' => $data['user_id'],
            'total_bill' => $data['rate'] * $data['pax'],
        ]);

        return redirect()->route('reservations.index')->with('success', 'Reservation and invoice created successfully.');
    }

    protected function generateUniqueOrderCode()
    {
        do {
            $orderCode = 'ORD' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
        } while (Reservation::where('order_code', $orderCode)->exists());

        return $orderCode;
    }

    public function show(Reservation $reservation)
    {
        return view('reservations.show', compact('reservation'));
    }

    public function edit(Reservation $reservation)
    {
        return view('reservations.edit', compact('reservation'));
    }

    public function update(Request $request, Reservation $reservation)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'checkin' => 'required|date',
            'checkout' => 'required|date',
            'res_category_id' => 'required|exists:res_categories,id_rescategory',
            'pax' => 'required|integer',
            'rate' => 'required|numeric',
            'note' => 'nullable|string',
            'id_sp' => 'nullable|exists:sales,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $reservation->update($request->all());

        return redirect()->route('reservations.index')->with('success', 'Reservation updated successfully.');
    }

    public function destroy($order_code)
    {
        $reservation = Reservation::where('order_code', $order_code)->first();

        if (!$reservation) {
            return redirect()->route('reservations.index')->with('error', 'Reservation not found.');
        }
        try {
            $reservation->delete();
            return redirect()->route('reservations.index')->with('success', 'Reservation deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('reservations.index')->with('error', 'An error occurred while deleting the reservation.');
        }
    }
}
