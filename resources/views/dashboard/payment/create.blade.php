@extends('layouts.app')
@section('content')
    <div class="row items-push">
        <div class="col-md-12">
            <a href="{{ route('invoice.index') }}" class="btn btn-primary btn-sm">Go Back</a>
        </div>
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('payment.store') }}" method="POST">
                        @csrf
                        @livewire('payment-create')
                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <input type="text" name="amount" id="amount" class="form-control"
                                placeholder="Enter Amount you Received">
                        </div>
                        <div class="form-group">
                            <label for="reduction">Reduction</label>
                            <input type="text" name="reduction" id="reduction" class="form-control"
                                placeholder="Enter extra discount for customer">
                        </div>
                        <div class="form-group">
                            <label for="payment_method">Payment Method</label>
                            <select name="payment_method" id="payment_method" class="js-select2 form-control form-select">
                                <option value="Cash" selected>Cash</option>
                                <option value="Bank">Bank</option>
                                <option value="Mobicash">Mobicash</option>
                                <option value="EasyPaisa">EasyPaisa</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="reference">Reference / Note</label>
                            <textarea name="reference" id="reference" cols="30" rows="2" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="Add Payment">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection