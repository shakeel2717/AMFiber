<div class="">

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
        <select wire:model.live="selectedCustomer" name="customer_id" id="customer_id" class="js-select2 form-control"
            wire:key="select-customer-{{ now() }}">
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
</div>
