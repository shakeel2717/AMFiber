@extends('layouts.app')
@section('content')
    <div class="row items-push">
        <div class="col-md-12">
            <a href="{{ route('invoice.index') }}" class="btn btn-primary btn-sm">Go Back</a>
        </div>
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-body">
                    @livewire('invoice-create')
                </div>
            </div>
        </div>
    </div>
@endsection
