@extends('layouts.min_print')
@section('content')
    <div>
        @include('inc.logo')
        <div class="header">
            <p>Date: {{ $invoice->created_at->format('d-m-Y') }}</p>
            <p>Invoice #: {{ $invoice->id }}</p>
        </div>

        <div class="details">
            <p><b>Customer:</b> {{ strtoupper($invoice->party->name) }}</p>
            <p><b>Phone:</b> {{ $invoice->party->phone }}</p>
            <p><b>Address:</b> {{ $invoice->party->address }}</p>
        </div>

        <div class="products">
            <table>
                <thead>
                    <tr>
                        <th>Qty</th>
                        <th>Product</th>
                        <th>Color</th>
                        <th>SQFT</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalSQFT = 0;
                    @endphp
                    @foreach ($invoice->invoice_products as $item)
                        <tr>
                            <td>{{ $item->qty }}</td>
                            <td>{{ $item->product->name }}</td>
                            <td>{{ $item->product->color ?? 'N/A' }}</td>
                            <td>{{ number_format($item->totalSquareFeet(), 2) }}</td>
                            <td>{{ number_format($item->price, 2) }}</td>
                            <td>{{ number_format($item->totalSquareFeet() * $item->price * $item->qty, 2) }}</td>
                            @php
                                $totalSQFT += $item->totalSquareFeet() * $item->qty;
                            @endphp
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="totals">
            <p><b>Total SQFT:</b> {{ number_format($totalSQFT, 2) }}</p>
            <p><b>Subtotal:</b> Rs: {{ number_format($invoice->calculateSubtotal(), 2) }}</p>
            <p><b>Discount:</b> -Rs: {{ number_format($invoice->calculateDiscount(), 2) }}</p>
            <p><b>Total After Discount:</b> Rs:
                {{ number_format($invoice->calculateSubtotal() - $invoice->calculateDiscount(), 2) }}</p>
            <p><b>Advance Payment:</b> Rs: {{ number_format($invoice->advance, 2) }}</p>

            @php
                $invoicePayments = $invoice->payments()->sum('amount');
                $finalBalance = $invoice->calculateGrandTotal() - $invoicePayments;
            @endphp

            @if ($invoicePayments > 0)
                <p><b>Payments Received:</b> Rs: {{ number_format($invoicePayments, 2) }}</p>
                @if ($finalBalance > 0)
                    <p><b>Remaining Balance:</b> Rs: {{ number_format($finalBalance, 2) }}</p>
                @elseif($finalBalance < 0)
                    <p><b>Overpaid Amount:</b> Rs: {{ number_format(abs($finalBalance), 2) }}</p>
                @else
                    <p><b>Status:</b> <span style="color: green;">PAID IN FULL</span></p>
                @endif
            @else
                <p><b>Balance Due:</b> Rs: {{ number_format($invoice->calculateGrandTotal(), 2) }}</p>
            @endif
        </div>

        @if ($invoice->payments()->count() > 0)
            <div class="payments-section" style="margin-top: 10px; border-top: 1px dashed #000; padding-top: 5px;">
                <p><b>Payment History:</b></p>
                @foreach ($invoice->payments as $payment)
                    <p style="font-size: 8px; margin: 1px 0;">
                        {{ $payment->created_at->format('d-M-Y') }} - Rs: {{ number_format($payment->amount, 2) }}
                        ({{ $payment->payment_method }})
                        @if ($payment->reference)
                            - {{ $payment->reference }}
                        @endif
                    </p>
                @endforeach
            </div>
        @endif

        <div class="footer">
            <p><b>Contact Numbers:</b></p>
            <p>03037489701 - 03047463506</p>
            <p>03008776701 - 03008777221</p>
            <p>03005561884 - 03048675586</p>
        </div>
    </div>
@endsection
