@extends('layouts.print')
@section('content')
    <div class="header">
        @include('inc.logo')
        <div class="labelandtime">
            <h1>Quotation</h1>
            <h5>Date: {{ $quotation->created_at->format('d-m-Y') }}</h5>
        </div>
    </div>

    <div class="details">
        <table>
            <tr>
                <th>Customer Detail:</th>
                <td>
                    <b>{{ strtoupper($quotation->party->name) }}</b>
                    <br>
                    <b>Phone:</b> {{ $quotation->party->phone }}
                    <br>
                    <b>Address:</b>
                    {{ $quotation->party->address }}
                </td>
                <th>Quotation #:</th>
                <td style="width: 100px">{{ $quotation->id }}</td>
            </tr>
        </table>
    </div>

    <div class="products">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">Details</th>
                    <th scope="col">Value</th>
                    <th scope="col">Price</th>
                    <th scope="col">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($quotation->quotation_items as $item)
                    <tr>
                        <th>Size</th>
                        <td style="text-align: right; font-weight: bold">{{ $item->width }}x{{ $item->height }}
                        </td>
                        <td rowspan="6" class="align-middle">Rs: {{ number_format($item->price, 2) }}</td>
                        <td rowspan="6" class="align-middle">Rs: {{ number_format($quotation->total_amount, 2) }}
                        </td>
                    </tr>
                    <tr>
                        <th>Specification</th>
                        <td>{{ $item->specification }}</td>
                    </tr>
                    <tr>
                        <th>Piller Pipe</th>
                        <td>{{ $item->piller }}</td>
                    </tr>
                    <tr>
                        <th>Shed Pipe</th>
                        <td>{{ $item->shed }}</td>
                    </tr>
                    <tr>
                        <th>Truss Pipe</th>
                        <td>{{ $item->truss }}</td>
                    </tr>
                    <tr>
                        <th>Thickness in mm</th>
                        <td>{{ $item->thickness }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>


    </div>

    <div class="highlighted-card">
        <div class="card">
            <div class="card-content">
                <h3 class="">Total Amount:
                    Rs: {{ number_format($quotation->total_amount - $quotation->paid_amount, 2) }}
                </h3>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-title">Terms and Conditions</div>
        <div class="card-content">
            <p>1. All quotations are valid for 30 days from the date of issue.</p>
        </div>
    </div>
    <div class="card">
        <div class="card-title">Note</div>
        <p class="note-text">Please review the quotation carefully. If you have any questions or need further
            clarification, feel
            free to contact us.</p>
    </div>
@endsection
