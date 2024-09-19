@extends('layouts.app')
@section('content')
    <div class="row items-push">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-4 text-start">
                                <a href="{{ route('payment.create') }}" class="btn btn-primary btn-sm">Add a Payment</a>
                            </div>
                            <livewire:all-parties />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
