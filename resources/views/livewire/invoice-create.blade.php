<div>
    <form>
        @csrf
        <div class="form-group">
            <label for="customer_search">Search Customer</label>
            <span wire:loading>
                <i class="fa fa-spinner fa-spin"></i>
            </span>
            <div class="input-group mb-3">
                <input 
                    type="text" 
                    class="form-control" 
                    placeholder="Search by name, email, or phone" 
                    wire:model.live.debounce.500ms="customerSearch"
                >
                <div class="input-group-append">
                    <button 
                        class="btn btn-outline-secondary" 
                        type="button" 
                        wire:click="clearCustomerSearch"
                    >
                        <i class="fa fa-times"></i>
                    </button>
                </div>
            </div>

            <label for="customer_id">Select Customer</label>
            <select 
                wire:model.live="selectedCustomer" 
                name="customer_id" 
                id="customer_id" 
                class="js-select2 form-control"
                wire:key="select-customer-{{ now() }}"
            >
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
        </div>

        <div class="form-group">
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="product_id">Select Product</label>
                        <select wire:model.live="selectedProduct" id="product_id" class="js-select2 form-control"
                            wire:key="select-product-{{ now() }}">
                            <option value="">Select a Product</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="plai_id">Select Plai</label>
                        <select wire:model.live="selectedPlai" id="plai_id" class="js-select2 form-control"
                            wire:key="select-plai-{{ now() }}">
                            <option value="">Select a Plai</option>
                            @foreach ($plais as $plai)
                                <option value="{{ $plai->id }}">{{ $plai->name }} ( Rs:{{ $plai->price }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <label for="width">Width in Feet Inches</label>
            <div class="input-group mb-3">
                <input type="number" min="0" wire:model.live="width_in_feet" class="form-control ml-2"
                    placeholder="Width (feet)" style="width: 80px;">
                <input type="number" min="0" wire:model.live="width_in_inches" class="form-control ml-2"
                    placeholder="Height (Inches)" style="width: 80px;">
            </div>
            <label for="width">Height in Feet Inches</label>
            <div class="input-group mb-3">
                <input type="number" min="0" wire:model.live="height_in_feet" class="form-control ml-2"
                    placeholder="Width (feet)" style="width: 80px;">
                <input type="number" min="0" wire:model.live="height_in_inches" class="form-control ml-2"
                    placeholder="Height (inches)" style="width: 80px;">

            </div>
            <div class="form-group">
                <label for="qty">Select Qty</label>
                <input type="number" min="1" wire:model.live="productQty" class="form-control ml-2"
                    placeholder="Qty">
            </div>
            @if ($selectedProduct && $selectedPlai && $productQty > 0 && $selectedCustomer)
                <div class="input-group-append">
                    <button type="button" wire:click="addProduct" class="btn btn-primary">Add</button>
                </div>
            @endif
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Width</th>
                        <th>Height</th>
                        <th>Qty</th>
                        <th>Price/sqft</th>
                        <th>Total Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($selectedProducts as $product)
                        <tr>
                            <td>{{ $product['name'] }}</td>
                            <td>{{ $product['width_in_feet'] }}.{{ $product['width_in_inches'] }}</td>
                            <td>{{ $product['height_in_feet'] }}.{{ $product['height_in_inches'] }}</td>
                            <td>{{ $product['qty'] }}</td>
                            <td>Rs:{{ number_format($product['price'], 2) }}</td>
                            <td>Rs:{{ number_format($product['total'], 2) }}</td>
                            <td><button type="button" wire:click="removeProduct({{ $product['id'] }})"
                                    class="btn btn-danger btn-sm">Remove</button></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="form-group">
            <label for="discount">Discount (%)</label>
            <input type="number" wire:model.live="discount" name="discount" id="discount" class="form-control"
                placeholder="Enter Discount" max="100" wire:change="calculateTotal()">
        </div>

        <div class="form-group">
            <label for="advance">Advance Payment</label>
            <input type="number" wire:model.live="advance" name="advance" id="advance" class="form-control"
                placeholder="Enter Advance Payment" max="100" wire:change="calculateTotal()">
        </div>

        <div class="form-group">
            <h4 class="mb-0">Total: Rs:{{ number_format($without_discounted_amount, 2) }}</h4>
            @if ($discounted_amount > 0)
                <h4 class="mb-0">Discount: Rs:{{ number_format($discounted_amount, 2) }}</h4>
                <h4 class="mb-0">Total: Rs:{{ number_format($totalAmount, 2) }}</h4>
            @endif
        </div>

        <button type="button" wire:click="createInvoice" class="btn btn-primary">Save Invoice</button>
    </form>
</div>
