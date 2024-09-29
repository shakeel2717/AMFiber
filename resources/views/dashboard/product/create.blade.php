@extends('layouts.app')
@section('content')
    <div class="row items-push">
        <div class="col-md-12">
            <a href="{{ route('product.index') }}" class="btn btn-primary btn-sm">Go Back</a>
        </div>
        <div class="col-md-6 mx-auto">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name">Product Name</label>
                            <input type="text" name="name" id="name" placeholder="Enter Product Name"
                                class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="image">Upload Product Image</label>
                            <input type="file" name="image" id="image" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="description">Product Description</label>
                            <input type="text" name="description" id="description"
                                placeholder="Enter Product Description" class="form-control">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-sm">Add Product</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
