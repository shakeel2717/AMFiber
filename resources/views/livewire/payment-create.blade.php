<div>
    <form wire:submit.prevent="submit" action="{{ route('payment.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="search">Search Customer</label>
            <input
                type="text"
                wire:model="search"
                class="form-control"
                id="search"
                placeholder="Search by ID or Name"
            />
            @error('search') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="customer_id">Select Customer</label>
            <select
                wire:model="selectedCustomer"
                name="customer_id"
                id="customer_id"
                class="js-select2 form-control"
                wire:key="select-customer-{{ now() }}">
                <option value="">Select a Customer</option>
                @foreach ($customers as $customer)
                    <option value="{{ $customer->id }}">
                        {{ $customer->name }}
                        @if($customer->email)
                            ({{ $customer->email }})
                        @endif
                    </option>
                @endforeach
            </select>
            @error('selectedCustomer') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!-- Amount Field -->
        <div class="form-group">
            <label for="amount">Amount</label>
            <input type="text" wire:model="amount" class="form-control" placeholder="Enter Amount you Received">
            @error('amount') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!-- Reduction Field -->
        <div class="form-group">
            <label for="reduction">Reduction</label>
            <input type="text" wire:model="reduction" class="form-control" placeholder="Enter extra discount for customer">
            @error('reduction') <span class="text-danger">{{ $message }}</span> @enderror
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
            @error('payment_method') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!-- Reference Field -->
        <div class="form-group">
            <label for="reference">Reference / Note</label>
            <textarea wire:model="reference" class="form-control" rows="2"></textarea>
            @error('reference') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!-- Submit Button -->
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Add Payment</button>
        </div>

        <!-- Success Message -->
        @if (session()->has('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
    </form>
</div>
