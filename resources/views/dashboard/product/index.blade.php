@extends('layouts.app')
@section('content')
    <div class="row items-push">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-4 text-start">
                                <a href="{{ route('product.create') }}" class="btn btn-primary btn-sm">Add a Product</a>
                            </div>
                            <livewire:all-product/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
