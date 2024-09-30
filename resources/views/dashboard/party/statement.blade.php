@extends('layouts.print')
@section('content')
    <div class="header">
        @include('inc.logo')
        <div class="labelandtime">
            <h1>Statement</h1>
            <h5>Date: {{ now()->format('d-m-Y') }}</h5>
        </div>
    </div>

    <div class="details">
        <table class="table table-bordered">
            <tr>
                <th>Customer Name:</th>
                <td>{{ $party->name }}</td>
            </tr>
            <tr>
                <th>Customer Address:</th>
                <td>{{ $party->address }}</td>
            </tr>
            <tr>
                <th>Customer Phone:</th>
                <td>{{ $party->phone }}</td>
            </tr>
        </table>
    </div>

    <div class="products">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Type</th>
                    <th>Reference</th>
                    <th>Credit</th>
                    <th>Debit</th>
                    <th>Balance</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $runningBalance = 0;
                @endphp

                @foreach ($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->created_at->format('d-m-Y') }}</td>
                        <td>{{ $transaction->type }}</td>
                        <td>{{ $transaction->reference ?? 'N/A' }}</td>
                        <td>
                            @if ($transaction->type === 'payment')
                                Rs: {{ number_format($transaction->amount, 2) }}
                                @php $runningBalance -= $transaction->amount; @endphp
                            @else
                                Rs: 0.00
                            @endif
                        </td>
                        <td>
                            @if ($transaction->type === 'invoice')
                                Rs: {{ number_format($transaction->amount, 2) }}
                                @php $runningBalance += $transaction->amount; @endphp
                            @else
                                Rs: 0.00
                            @endif
                        </td>
                        <td>Rs: {{ number_format($runningBalance, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="highlighted-card">
        <div class="card">
            <div class="card-content">
                <h3 class="">Balance: Rs: {{ number_format($party->balance(), 2) }}</h3>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-title">Terms and Conditions</div>
        <div class="card-content">
            <p>All services are provided in accordance with the service agreement signed at the time of contract initiation.
                Any changes to the agreement must be documented and approved by both parties.</p>
        </div>
    </div>
    <div class="card">
        <div class="card-title">Note</div>
        <p class="note-text">Please review the statement carefully. If you have any questions or need further
            clarification, feel
            free to contact us.</p>
    </div>
@endsection
