<?php

namespace App\Http\Controllers;

use App\Models\WigCheckin;
use App\Models\WigInvoice;
use Illuminate\Http\Request;

class WigCheckinController extends Controller
{
    public function index()
    {
        $wigcheckins = WigCheckin::all();
        return view('wigcheckin.index', compact('wigcheckins'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'guest_name' => 'required|string|max:255',
            'room' => 'required|string|max:255',
            'rate' => 'required|numeric',
            'pay' => 'required|numeric',
            'checkin_time' => 'required|date',
            'checkout_time' => 'nullable|date',
            'status' => 'nullable|string|max:255',
        ]);

        // Generate checkin_code automatically
        $validatedData['checkin_code'] = WigCheckin::generateCheckinCode();
        // Set default status to 'checkin' if not provided
        $validatedData['status'] = $validatedData['status'] ?? 'checkin';

        // Create the checkin record
        $wigCheckin = WigCheckin::create($validatedData);

        // Create the invoice for this checkin
        WigInvoice::create([
            'checkin_code' => $wigCheckin->checkin_code,
            'payment' => $validatedData['pay'], // Assuming payment represents the total amount
        ]);

        return redirect()->route('wigcheckins.index')->with('success', 'Check-In and Invoice added successfully.');
    }

    public function showInvoice($checkin_code)
    {
        $wigcheckin = WigCheckin::with('wigInvoice')->where('checkin_code', $checkin_code)->first();

        if (!$wigcheckin) {
            return redirect()->route('wigcheckins.index')->with('error', 'Check-In not found.');
        }

        return view('wigcheckin.invoice', compact('wigcheckin'));
    }
}
