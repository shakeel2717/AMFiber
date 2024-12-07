<div class="">
    <form action="{{ route('payment.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="customer_search">Search Customer</label>
            <span wire:loading>
                <i class="fa fa-spinner fa-spin"></i>
            </span>
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Search by name, email, or phone"
                    wire:model.live.debounce.500ms="customerSearch">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button" wire:click="clearCustomerSearch">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
            </div>

            <label for="customer_id">Select Customer</label>
            <select wire:model.live="selectedCustomer" name="customer_id" id="customer_id"
                class="js-select2 form-control" wire:key="select-customer-{{ now() }}">
                <option value="">Select a Customer</option>
                @foreach ($customers as $customer)
                    <option value="{{ $customer->id }}">
                        {{ $customer->name }}
                        @if ($customer->email)
                            ({{ $customer->email }})
                        @endif
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Amount Field -->
        <div class="form-group">
            <label for="amount">Amount</label>
            <input type="text" wire:model="amount" class="form-control" placeholder="Enter Amount you Received">
        </div>

        <!-- Reduction Field -->
        <div class="form-group">
            <label for="reduction">Reduction</label>
            <input type="text" wire:model="reduction" class="form-control"
                placeholder="Enter extra discount for customer">
        </div>

        <!-- Payment Method -->
        <div class="form-group">
            <label for="payment_method">Payment Method</label>
            <select wire:model="payment_method" class="form-control">
                <option value="Cash">Cash</option>
                <option value="Bank">Bank</option>
                <option value="Mobicash">Mobicash</option>
                <option value="EasyPaisa">EasyPaisa</option>
            </select>
        </div>

        <!-- Reference Field -->
        <div class="form-group">
            <label for="reference">Reference / Note</label>
            <textarea wire:model="reference" class="form-control" rows="2"></textarea>
        </div>

        <!-- Submit Button -->
        <div class="form-group">
            <button type="submit" wire:click="submit" class="btn btn-primary">Add Payment</button>
        </div>

        <!-- Success Message -->
        @if (session()->has('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
</div>

</form>
</div>
