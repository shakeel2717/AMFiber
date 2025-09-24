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

    @if($selectedCustomer && count($invoices) > 0)
        <div class="form-group">
            <label for="invoice_id">Select Invoice (Optional)</label>
            <select wire:model="selectedInvoice" name="invoice_id" id="invoice_id" class="form-control">
                <option value="">Select an Invoice (Optional)</option>
                @foreach ($invoices as $invoice)
                    <option value="{{ $invoice->id }}">
                        Invoice #{{ $invoice->id }} - Rs {{ number_format($invoice->calculateGrandTotal(), 2) }}
                        ({{ $invoice->created_at->format('d-M-Y') }})
                    </option>
                @endforeach
            </select>
        </div>
    @endif

    @if($selectedCustomer && count($invoices) == 0)
        <div class="alert alert-info">
            <small>No pending invoices found for this customer.</small>
        </div>
    @endif
</div>