<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Party;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;

class PartyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("dashboard.party.index");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("dashboard.party.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'type' => 'required',
        ]);

        $user = Party::create($validatedData);

        return to_route('party.index')->with('success', 'Party Added Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }


    public function statement($id)
    {
        // Fetch customer/vendor details
        $party = Party::findOrFail($id);

        // Fetch all invoices and payments related to this party
        $invoices = Invoice::where('customer_id', $id)->get();
        $payments = Payment::where('party_id', $id)->get();

        // Combine invoices and payments into a single collection
        $transactions = $invoices->map(function ($invoice) {
            return (object) [
                'type' => 'invoice',
                'reference' => 'Invoice #' . $invoice->id,
                'amount' => $invoice->total_amount,
                'created_at' => $invoice->created_at,
                'total_amount' => $invoice->total_amount
            ];
        })->merge($payments->map(function ($payment) {
            return (object) [
                'type' => 'payment',
                'reference' => $payment->reference,
                'amount' => $payment->amount,
                'created_at' => $payment->created_at,
                'total_amount' => 0
            ];
        }))->sortBy('created_at');

        return view('dashboard.party.statement', compact('party', 'transactions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
