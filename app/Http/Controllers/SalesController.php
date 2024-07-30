<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SalesController extends Controller
{
    public function index()
    {
        $sales = Sales::all();
        return view('reservation.sales', compact('sales'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nik' => 'required|string|max:20|unique:sales,nik',
            'address' => 'required|string',
            'ktp_address' => 'required|string',
            'no_hp' => 'required|string|max:15',
            'ktp_foto' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('ktp_foto')) {
            $data['ktp_foto'] = $request->file('ktp_foto')->store('ktp_foto', 'public');
        }

        Sales::create($data);

        return redirect()->route('sales.index')->with('success', 'Sales created successfully.');
    }

    public function update(Request $request, Sales $sales)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nik' => 'required|string|max:20|unique:sales,nik,' . $sales->id,
            'address' => 'required|string',
            'ktp_address' => 'required|string',
            'no_hp' => 'required|string|max:15',
            'ktp_foto' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('ktp_foto')) {
            if ($sales->ktp_foto) {
                Storage::delete('public/' . $sales->ktp_foto);
            }
            $data['ktp_foto'] = $request->file('ktp_foto')->store('ktp_foto', 'public');
        }

        $sales->update($data);

        return redirect()->route('sales.index')->with('success', 'Sales updated successfully.');
    }

    public function destroy(Sales $sales)
    {
        if ($sales->ktp_foto) {
            Storage::delete('public/' . $sales->ktp_foto);
        }
        $sales->delete();
        return redirect()->route('sales.index')->with('success', 'Sales deleted successfully.');
    }
}
