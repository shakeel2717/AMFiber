@extends('layouts.print')
@section('content')
    <div class="header">
        <h1 class="text-primary">{{ config('app.name') }}</h1>
        <div class="labelandtime">
            <h1>Invoice</h1>
            <h5>Date: {{ $invoice->created_at->format('d-m-Y') }}</h5>
        </div>
    </div>

    <div class="details">
        <table>
            <tr>
                <th>Customer Name:</th>
                <td>{{ $invoice->party->name }}</td>
            </tr>
            <tr>
                <th>Customer Address:</th>
                <td>{{ $invoice->party->address }}</td>
            </tr>
            <tr>
                <th>Customer Phone:</th>
                <td>{{ $invoice->party->phone }}</td>
            </tr>
            <tr>
                <th>Invoice Number:</th>
                <td>{{ $invoice->id }}</td>
            </tr>
        </table>
    </div>

    <div class="products">
        <table>
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Dimensions (W x H)</th>
                    <th>Total SQFT</th>
                    <th>Quantity</th>
                    <th>Unit Price (per sqft)</th>
                    <th>Line Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoice->invoice_products as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->width_in_feet . '\'.' . $item->width_in_inches }}"
                            x{{ $item->height_in_feet . '\'.' . $item->height_in_inches }}"</td>
                        <td>{{ number_format($item->totalSquareFeet(), 2) }}</td>
                        <td>{{ $item->qty }}</td>
                        <td>Rs: {{ number_format($item->price, 2) }}</td>
                        <td>Rs: {{ number_format($item->totalSquareFeet() * $item->price * $item->qty, 2) }}
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <th style="text-align: right" colspan="5">Subtotal</th>
                    <th>Rs: {{ number_format($invoice->calculateSubtotal(), 2) }}</th>
                </tr>
                <tr>
                    <th style="text-align: right" colspan="5">Discount ({{ $invoice->discount }}%)</th>
                    <th>- Rs: {{ number_format($invoice->calculateDiscount(), 2) }}</th>
                </tr>
                <tr>
                    <th style="text-align: right" colspan="5">Grand Total</th>
                    <th>Rs: {{ number_format($invoice->calculateGrandTotal(), 2) }}</th>
                </tr>
            </tbody>
        </table>

    </div>

    <div class="highlighted-card">
        <div class="card">
            <div class="card-content">
                <h3 class="">Balance:
                    Rs: {{ number_format($invoice->party->balance(), 2) }}
                </h3>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-title">Terms and Conditions</div>
        <div class="card-content">
            <p>1. All Invoices are valid for 30 days from the date of issue.</p>
        </div>
    </div>
    <div class="card">
        <div class="card-title">Note</div>
        <p class="note-text">Please review the invoice carefully. If you have any questions or need further
            clarification, feel
            free to contact us.</p>
    </div>

    <div class="footer">
        <p>Thank you for your business!</p>
    </div>
@endsection
