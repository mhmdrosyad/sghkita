<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CustomerImport;


class CustomerController extends Controller
{
    // Display a listing of the customers
    public function index()
    {
        // Ambil customer yang pernah melakukan reservasi
        $customersWithReservations = Customer::with('reservations')->has('reservations')->get();

        // Ambil semua customer dan tambahkan status
        $allCustomers = Customer::all()->map(function ($customer) {
            // Tambahkan status berdasarkan apakah customer memiliki reservasi
            $customer->status = $customer->reservations->isEmpty() ? 'Calon Customer' : 'Customer Aktif';
            return $customer;
        });

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

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        Excel::import(new CustomerImport, $request->file('file')->store('temp'));

        return redirect()->back()->with('success', 'Data Customer berhasil diimport!');
    }
}
