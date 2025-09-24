@extends('layouts.print')
@section('content')
    <div>
        <div class="header">
            @include('inc.logo')
            <div class="labelandtime">
                <h1>Invoice</h1>
                <h5>Date: {{ $invoice->created_at->format('d-m-Y') }}</h5>
            </div>
        </div>

        <div class="details">
            <table>
                <tr  class="small-text">
                    <th>Customer Detail:</th>
                    <td>
                        <b>{{ strtoupper($invoice->party->name) }}</b>
                        <br>
                        <b>Phone:</b> {{ $invoice->party->phone }}
                        <br>
                        <b>Address:</b>
                        {{ $invoice->party->address }}
                    </td>
                    <th>Invoice #:</th>
                    <td style="width: 100px">{{ $invoice->id }}</td>
                </tr>
            </table>
        </div>

        <div class="highlighted-card">
            <div class="card">
                <div class="card-content">
                    <h3 class="">Customer Balance:
                        Rs: {{ number_format($invoice->party->balance(), 2) }}
                    </h3>
                </div>
            </div>
        </div>

        <div class="products">
            <table>
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Color</th>
                        <th>Total SQFT</th>
                        <th>Quantity</th>
                        <th>Unit Price (per sqft)</th>
                        <th>Line Total</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $totalSQFT = 0;
                    @endphp
                    @foreach ($invoice->invoice_products as $item)
                        <tr  class="small-text">
                            <td>
                                <b>
                                    {{ $item->product->name }} <br>
                                    <span>Dimensions (W x H) <br></span>
                                    {{ $item->width_in_feet . '\'.' . $item->width_in_inches }}"
                                    x{{ $item->height_in_feet . '\'.' . $item->height_in_inches }}"
                                </b>
                            </td>
                            <td>{{ $item->product->color ?? 'N/A' }}</td>
                            <td>{{ number_format($item->totalSquareFeet(), 2) }}</td>
                            <td>{{ $item->qty }}</td>
                            <td>Rs: {{ number_format($item->price, 2) }}</td>
                            <td>Rs: {{ number_format($item->totalSquareFeet() * $item->price * $item->qty, 2) }}</td>
                            @php
                                $totalSQFT += $item->totalSquareFeet() * $item->qty;
                            @endphp
                        </tr>
                    @endforeach
                    <tr>
                        <td></td>
                        <td></td>
                        <td style="font-size: 10px;">{{ number_format($totalSQFT,2) }}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr class="small-text">
                        <th style="text-align: right;" colspan="5">Subtotal</th>
                        <th>Rs: {{ number_format($invoice->calculateSubtotal(), 2) }}</th>
                    </tr>
                    <tr class="small-text">
                        <th style="text-align: right;" colspan="5">Discount </th>
                        <th>- Rs: {{ number_format($invoice->calculateDiscount(), 2) }}</th>
                    </tr>
                    <tr class="small-text">
                        <th style="text-align: right;" colspan="5">Total After Discount</th>
                        <th>Rs: {{ number_format($invoice->calculateSubtotal() - $invoice->calculateDiscount(), 2) }}
                        </th>
                    </tr>
                    <tr class="small-text">
                        <th style="text-align: right;" colspan="5">Advance Payment</th>
                        <th>Rs: {{ number_format($invoice->advance, 2) }}</th>
                    </tr>

                    @php
                        $invoicePayments = $invoice->payments()->sum('amount');
                        $finalBalance = $invoice->calculateGrandTotal() - $invoicePayments;
                    @endphp

                    @if($invoicePayments > 0)
                        <tr class="small-text">
                            <th style="text-align: right;" colspan="5">Payments Received</th>
                            <th>Rs: {{ number_format($invoicePayments, 2) }}</th>
                        </tr>
                        @if($finalBalance > 0)
                            <tr class="small-text">
                                <th style="text-align: right;" colspan="5">Remaining Balance</th>
                                <th>Rs: {{ number_format($finalBalance, 2) }}</th>
                            </tr>
                        @elseif($finalBalance < 0)
                            <tr class="small-text">
                                <th style="text-align: right;" colspan="5">Overpaid Amount</th>
                                <th>Rs: {{ number_format(abs($finalBalance), 2) }}</th>
                            </tr>
                        @else
                            <tr class="small-text">
                                <th style="text-align: right;" colspan="5">Status</th>
                                <th style="color: green;">PAID IN FULL</th>
                            </tr>
                        @endif
                    @else
                        <tr class="small-text">
                            <th style="text-align: right;" colspan="6">Balance Due</th>
                            <th>Rs: {{ number_format($invoice->calculateGrandTotal(), 2) }}</th>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        @if($invoice->payments()->count() > 0)
            <div style="margin-top: 15px;">
                <h5 style="margin: 0">Payment History</h5>
                <table style="width: 100%; margin-top: 5px;">
                    <thead>
                        <tr class="small-text">
                            <th style="border: 1px solid black; padding: 5px;">Date</th>
                            <th style="border: 1px solid black; padding: 5px;">Amount</th>
                            <th style="border: 1px solid black; padding: 5px;">Method</th>
                            <th style="border: 1px solid black; padding: 5px;">Reference</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invoice->payments as $payment)
                            <tr class="small-text">
                                <td style="border: 1px solid black; padding: 5px;">{{ $payment->created_at->format('d-M-Y') }}</td>
                                <td style="border: 1px solid black; padding: 5px;">Rs: {{ number_format($payment->amount, 2) }}</td>
                                <td style="border: 1px solid black; padding: 5px;">{{ $payment->payment_method }}</td>
                                <td style="border: 1px solid black; padding: 5px;">{{ $payment->reference ?? 'N/A' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <div class="">
            <h5 class="" style="margin: 0">Terms and Conditions</h5>
            <div class="card-content">
                <p style="margin: 0">1. All Invoices are valid for 30 days from the date of issue.</p>
            </div>
        </div>
        <div class="" style="margin-top: 10px">
            <h5 class="" style="margin: 0">Note</h5>
            <p class="note-text" style="margin: 0">Please review the invoice carefully. If you have any questions or need further
                clarification, feel
                free to contact us.</p>
        </div>
    </div>
@endsection