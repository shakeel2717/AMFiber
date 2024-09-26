@extends('layouts.app')
@section('content')
    <div class="row items-push">
        <div class="col-md-12">
            <a href="{{ route('plai.index') }}" class="btn btn-primary btn-sm">Go Back</a>
        </div>
        <div class="col-md-6 mx-auto">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('plai.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name">Plai Name</label>
                            <input type="text" name="name" id="name" placeholder="Enter Plai Name"
                                class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="price">Plai Price Square Feet</label>
                            <input type="text" name="price" id="price" placeholder="Enter Plai Price Square Feet"
                                class="form-control">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-sm">Add Plai</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
