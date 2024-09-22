<div>
    <form>
        @csrf
        <div class="form-group">
            <label for="customer_id">Select Customer</label>
            <select wire:model.live="selectedCustomer" name="customer_id" id="customer_id" class="form-control"
                wire:key="select-customer-{{ now() }}">
                <option value="">Select a Customer</option>
                @foreach ($customers as $customer)
                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <div class="form-group">
                <label for="product_id">Select Product</label>
                <select wire:model.live="selectedProduct" id="product_id" class="form-control"
                    wire:key="select-product-{{ now() }}">
                    <option value="">Select a Product</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }} - ${{ $product->price }}</option>
                    @endforeach
                </select>
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
            <div class="input-group-append">
                <button type="button" wire:click="addProduct" class="btn btn-primary">Add</button>
            </div>
        </div>

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
                        <td>
                            <input type="number" min="1" class="form-control"
                                wire:model.live="quantities.{{ $product['id'] }}"
                                wire:change="updateProduct({{ $product['id'] }})">
                        </td>
                        <td>Rs:{{ $product['price'] }}</td>
                        <td>Rs:{{ $product['total'] }}</td>
                        <td><button type="button" wire:click="removeProduct({{ $product['id'] }})"
                                class="btn btn-danger btn-sm">Remove</button></td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="form-group">
            <label for="discount">Discount (%)</label>
            <input type="number" wire:model="discount" name="discount" id="discount" class="form-control"
                placeholder="Enter Discount" max="100" wire:change="calculateTotal()">
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
