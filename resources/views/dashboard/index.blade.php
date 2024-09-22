@extends('layouts.app')
@section('content')
    <div class="row items-push">
        <div class="col-sm-6 col-xl-4">
            <div class="block block-rounded text-center d-flex flex-column h-100 mb-0">
                <div class="block-content block-content-full flex-grow-1">
                    <div class="item rounded-3 bg-body mx-auto my-3">
                        <i class="fa fa-users fa-lg text-primary"></i>
                    </div>
                    <div class="fs-1 fw-bold">{{ $customers->count() }}</div>
                    <div class="text-muted mb-3">Total Customers</div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-4">
            <div class="block block-rounded text-center d-flex flex-column h-100 mb-0">
                <div class="block-content block-content-full flex-grow-1">
                    <div class="item rounded-3 bg-body mx-auto my-3">
                        <i class="fa fa-users fa-lg text-primary"></i>
                    </div>
                    <div class="fs-1 fw-bold">{{ $invoices->count() }}</div>
                    <div class="text-muted mb-3">Total Invoices</div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-4">
            <div class="block block-rounded text-center d-flex flex-column h-100 mb-0">
                <div class="block-content block-content-full flex-grow-1">
                    <div class="item rounded-3 bg-body mx-auto my-3">
                        <i class="fa fa-users fa-lg text-primary"></i>
                    </div>
                    <div class="fs-1 fw-bold">{{ $quotations->count() }}</div>
                    <div class="text-muted mb-3">Total Quotations</div>
                </div>
            </div>
        </div>
    </div>
@endsection
