<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    // Display a listing of the customers
    public function index()
    {
        // Ambil customer yang pernah melakukan reservasi
        $customersWithReservations = Customer::has('reservations')->get();

        // Ambil semua customer
        $allCustomers = Customer::all();

        return view('reservation.customer', compact('customersWithReservations', 'allCustomers'));
    }


    // Store a newly created customer in storage
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'agency' => 'nullable|string|max:255',
            'no_hp' => 'required|string|max:15',
            'no_hp_alt' => 'nullable|string|max:15',
        ]);

        Customer::create($request->all());
        return redirect()->back()->with('success', 'Customer created successfully.');
    }

    // Update the specified customer in storage
    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'agency' => 'nullable|string|max:255',
            'no_hp' => 'required|string|max:15',
            'no_hp_alt' => 'nullable|string|max:15',
        ]);

        $customer->update($request->all());
        return redirect()->back()->with('success', 'Customer updated successfully.');
    }

    // Remove the specified customer from storage
    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->back()->with('success', 'Customer deleted successfully.');
    }
}
