@extends('layouts.min_print')
@section('content')
    <div>
        <div class="header">
            <h3 style="text-align: center;">Al-Mukhtar Fiber Glass House</h3>
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
            <p><b>Total SQFT:</b> {{ number_format($totalSQFT,2) }}</p>
            <p><b>Subtotal:</b> Rs: {{ number_format($invoice->calculateSubtotal(), 2) }}</p>
            <p><b>Discount:</b> -Rs: {{ number_format($invoice->calculateDiscount(), 2) }}</p>
            <p><b>Total After Discount:</b> Rs:
                {{ number_format($invoice->calculateSubtotal() - $invoice->calculateDiscount(), 2) }}</p>
            <p><b>Advance Payment:</b> Rs: {{ number_format($invoice->advance, 2) }}</p>
            <p><b>Balance Due:</b> Rs: {{ number_format($invoice->calculateGrandTotal(), 2) }}</p>
        </div>

        <div class="footer">
            <p>Thank you for your business!</p>
        </div>
    </div>
@endsection
