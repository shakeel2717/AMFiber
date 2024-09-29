@extends('layouts.app')
@section('content')
    <div class="row items-push">
        <div class="col-sm-6 col-xl-4">
            <a href="{{ route('party.index') }}" class="">
                <div class="block block-rounded text-center d-flex flex-column h-100 mb-0">
                    <div class="block-content block-content-full flex-grow-1">
                        <div class="item rounded-3 bg-body mx-auto my-3">
                            <i class="fa fa-users fa-lg text-primary"></i>
                        </div>
                        <div class="fs-1 fw-bold">{{ $customers->count() }}</div>
                        <div class="text-muted mb-3">Total Customers</div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-xl-4">
            <a href="{{ route('invoice.index') }}" class="">
                <div class="block block-rounded text-center d-flex flex-column h-100 mb-0">
                    <div class="block-content block-content-full flex-grow-1">
                        <div class="item rounded-3 bg-body mx-auto my-3">
                            <i class="fa fa-users fa-lg text-primary"></i>
                        </div>
                        <div class="fs-1 fw-bold">{{ $invoices->count() }}</div>
                        <div class="text-muted mb-3">Total Invoices</div>
                    </div>
                </div>
            </a>

        </div>
        <div class="col-sm-6 col-xl-4">
            <a href="{{ route('quotation.index') }}" class="">
                <div class="block block-rounded text-center d-flex flex-column h-100 mb-0">
                    <div class="block-content block-content-full flex-grow-1">
                        <div class="item rounded-3 bg-body mx-auto my-3">
                            <i class="fa fa-users fa-lg text-primary"></i>
                        </div>
                        <div class="fs-1 fw-bold">{{ $quotations->count() }}</div>
                        <div class="text-muted mb-3">Total Quotations</div>
                    </div>
                </div>
            </a>

        </div>
    </div>
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Add Invoice</h5>
                    <p class="card-text">Easily create and manage your invoices.</p>
                    <a href="{{ route('invoice.create') }}" class="btn btn-primary">Create Invoice</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Add Quotation</h5>
                    <p class="card-text">Record a new quotation.</p>
                    <a href="{{ route('quotation.create') }}" class="btn btn-primary">Add Quotation</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Add Payment</h5>
                    <p class="card-text">Record a new payment.</p>
                    <a href="{{ route('payment.create') }}" class="btn btn-primary">Add Payment</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row items-push">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">Recent Notifications</h3>
                    <livewire:all-notification />
                </div>
            </div>
        </div>
    </div>
@endsection
