<div>
    <div class="mb-4">
        <h5>Editing Invoice #{{ $invoice->id }} for {{ $invoice->party->name }}</h5>
    </div>

    <!-- Add New Product Section -->
    <div class="card mb-4">
        <div class="card-header">
            <h6>Add New Product</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="product_id">Select Product</label>
                        <select wire:model.live="selectedProduct" id="product_id" class="form-control">
                            <option value="">Select a Product</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="plai_id">Select Plai</label>
                        <select wire:model.live="selectedPlai" id="plai_id" class="form-control">
                            <option value="">Select a Plai</option>
                            @foreach ($plais as $plai)
                                <option value="{{ $plai->id }}">{{ $plai->name }} (Rs: {{ $plai->price }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <label>Width in Feet & Inches</label>
                    <div class="input-group mb-3">
                        <input type="number" min="0" wire:model.live="width_in_feet" class="form-control"
                            placeholder="Feet">
                        <input type="number" min="0" wire:model.live="width_in_inches" class="form-control"
                            placeholder="Inches">
                    </div>
                </div>
                <div class="col-6">
                    <label>Height in Feet & Inches</label>
                    <div class="input-group mb-3">
                        <input type="number" min="0" wire:model.live="height_in_feet" class="form-control"
                            placeholder="Feet">
                        <input type="number" min="0" wire:model.live="height_in_inches" class="form-control"
                            placeholder="Inches">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Quantity</label>
                <input type="number" min="1" wire:model.live="productQty" class="form-control"
                    placeholder="Qty">
            </div>

            @if ($selectedProduct && $selectedPlai && $productQty > 0)
                <button type="button" wire:click="addProduct" class="btn btn-primary">Add Product</button>
            @endif
        </div>
    </div>

    <!-- Existing Products Table -->
    <div class="card mb-4">
        <div class="card-header">
            <h6>Invoice Products</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Width (ft.in)</th>
                            <th>Height (ft.in)</th>
                            <th>Qty</th>
                            <th>Price/sqft</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoiceProducts as $index => $product)
                            <tr>
                                <td>{{ $product['name'] }}</td>
                                <td>
                                    <input type="number"
                                        wire:change="updateProduct({{ $index }}, 'width_in_feet', $event.target.value)"
                                        value="{{ $product['width_in_feet'] }}" class="form-control form-control-sm"
                                        style="width: 60px; display: inline-block;">
                                    .
                                    <input type="number"
                                        wire:change="updateProduct({{ $index }}, 'width_in_inches', $event.target.value)"
                                        value="{{ $product['width_in_inches'] }}" class="form-control form-control-sm"
                                        style="width: 60px; display: inline-block;">
                                </td>
                                <td>
                                    <input type="number"
                                        wire:change="updateProduct({{ $index }}, 'height_in_feet', $event.target.value)"
                                        value="{{ $product['height_in_feet'] }}" class="form-control form-control-sm"
                                        style="width: 60px; display: inline-block;">
                                    .
                                    <input type="number"
                                        wire:change="updateProduct({{ $index }}, 'height_in_inches', $event.target.value)"
                                        value="{{ $product['height_in_inches'] }}" class="form-control form-control-sm"
                                        style="width: 60px; display: inline-block;">
                                </td>
                                <td>
                                    <input type="number"
                                        wire:change="updateProduct({{ $index }}, 'qty', $event.target.value)"
                                        value="{{ $product['qty'] }}" class="form-control form-control-sm"
                                        style="width: 80px;">
                                </td>
                                <td>Rs: {{ number_format($product['price'], 2) }}</td>
                                <td>Rs: {{ number_format($product['total'], 2) }}</td>
                                <td>
                                    <button type="button" wire:click="removeProduct({{ $index }})"
                                        class="btn btn-danger btn-sm">Remove</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Invoice Totals -->
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Discount Amount</label>
                <input type="number" wire:model.live="discount" wire:change="calculateTotal()" class="form-control"
                    placeholder="Enter Discount Amount">
            </div>

            <div class="form-group">
                <label>Advance Payment</label>
                <input type="number" wire:model.live="advance" wire:change="calculateTotal()" class="form-control"
                    placeholder="Enter Advance Payment">
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h6>Invoice Summary</h6>
                    <p><strong>Subtotal:</strong> Rs: {{ number_format($without_discounted_amount, 2) }}</p>
                    @if ($discounted_amount > 0)
                        <p><strong>Discount:</strong> Rs: {{ number_format($discounted_amount, 2) }}</p>
                    @endif
                    <p><strong>Total:</strong> Rs: {{ number_format($totalAmount, 2) }}</p>
                    @if ($advance > 0)
                        <p><strong>Advance:</strong> Rs: {{ number_format($advance, 2) }}</p>
                        <p><strong>Balance Due:</strong> Rs: {{ number_format($totalAmount - $advance, 2) }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="text-center mt-4">
        <button type="button" wire:click="updateInvoice" class="btn btn-success btn-lg">Update Invoice</button>
    </div>
</div>
