@extends('layouts.app')
@section('content')
    <div class="row items-push">
        <div class="col-sm-6 col-xl-3">
            <div class="block block-rounded text-center d-flex flex-column h-100 mb-0">
                <div class="block-content block-content-full flex-grow-1">
                    <div class="item rounded-3 bg-body mx-auto my-3">
                        <i class="fa fa-users fa-lg text-primary"></i>
                    </div>
                    <div class="fs-1 fw-bold">{{ 0 }}</div>
                    <div class="text-muted mb-3">Total Business</div>
                </div>
            </div>
        </div>
    </div>
@endsection
