<?php

namespace App\Http\Controllers;

use App\Models\Party;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.payment.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Party::where('type', 'customer')->get();
        return view('dashboard.payment.create', compact('customers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:parties,id',
            'amount' => 'required|numeric',
            'payment_method' => 'required|string',
            'reference' => 'nullable|string',
            'reduction' => 'nullable|numeric',
        ]);

        $payment = new Payment();
        $payment->party_id = $validated['customer_id'];
        $payment->amount = $validated['amount'];
        $payment->payment_method = $validated['payment_method'];
        $payment->reference = $validated['reference'];
        $payment->save();

        if ($validated['reduction'] > 0) {
            $payment = new Payment();
            $payment->party_id = $validated['customer_id'];
            $payment->amount = $validated['reduction'];
            $payment->payment_method = $validated['payment_method'];
            $payment->reference = "Reduction Adjustment";
            $payment->save();
        }

        return redirect()->route('payment.index')->with('success', 'Payment created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
