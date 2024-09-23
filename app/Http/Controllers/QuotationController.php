<?php

namespace App\Http\Controllers;

use App\Models\Quotation;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class QuotationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.quotation.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.quotation.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $quotation = Quotation::with('quotation_items', 'party')->findOrFail($id);
        return view('dashboard.quotation.show', compact('quotation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Quotation $quotation)
    {
        $pdf = Pdf::loadView('dashboard.quotation.show', ['quotation' => $quotation])->setPaper('a4');
        return $pdf->download($quotation->party->name . '_quotation-' . $quotation->id . '.pdf');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Quotation $quotation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quotation $quotation)
    {
        //
    }
}
