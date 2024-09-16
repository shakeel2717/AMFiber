@extends('layouts.app')
@section('content')
    <div class="row items-push">
        <div class="col-md-12">
            <a href="{{ route('party.create') }}" class="btn btn-primary btn-sm">Add a Party</a>
        </div>
    </div>
@endsection
