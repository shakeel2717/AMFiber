<div>
    <!-- Customer Selection Section -->
    <div class="card mb-4">
        <div class="card-header">
            <h6 class="mb-0">Customer Information</h6>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label for="customer_search">Search Customer</label>
                <span wire:loading wire:target="updatedCustomerSearch">
                    <i class="fa fa-spinner fa-spin"></i>
                </span>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Search by name or phone"
                        wire:model.live.debounce.500ms="customerSearch">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button" wire:click="clearCustomerSearch">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                </div>

                <label for="customer_id">Select Customer</label>
                <select wire:model.live="selectedCustomer" name="customer_id" id="customer_id"
                    class="form-control" wire:key="select-customer-{{ now() }}">
                    <option value="">Select a Customer</option>
                    @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}">
                            {{ $customer->name }}
                            @if ($customer->phone)
                                - {{ $customer->phone }}
                            @endif
                        </option>
                    @endforeach
                </select>
                
                @if($selectedCustomer)
                    @php $customer = $customers->find($selectedCustomer) @endphp
                    <div class="mt-2 p-2 bg-light rounded">
                        <small><strong>Balance:</strong> Rs {{ number_format($customer->balance(), 2) }}</small>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Product Selection Section -->
    <div class="card mb-4">
        <div class="card-header">
            <h6 class="mb-0">Add Products</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="product_id">Select Product</label>
                        <select wire:model.live="selectedProduct" id="product_id" class="form-control"
                            wire:key="select-product-{{ now() }}">
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
                        <select wire:model.live="selectedPlai" id="plai_id" class="form-control"
                            wire:key="select-plai-{{ now() }}">
                            <option value="">Select a Plai</option>
                            @foreach ($plais as $plai)
                                <option value="{{ $plai->id }}">{{ $plai->name }} (Rs {{ $plai->price }}/sqft)</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <label>Width (Feet & Inches)</label>
                    <div class="input-group mb-3">
                        <input type="number" min="0" step="0.01" wire:model.live="width_in_feet" 
                               class="form-control" placeholder="Feet">
                        <div class="input-group-text">ft</div>
                        <input type="number" min="0" max="11" wire:model.live="width_in_inches" 
                               class="form-control" placeholder="Inches">
                        <div class="input-group-text">in</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <label>Height (Feet & Inches)</label>
                    <div class="input-group mb-3">
                        <input type="number" min="0" step="0.01" wire:model.live="height_in_feet" 
                               class="form-control" placeholder="Feet">
                        <div class="input-group-text">ft</div>
                        <input type="number" min="0" max="11" wire:model.live="height_in_inches" 
                               class="form-control" placeholder="Inches">
                        <div class="input-group-text">in</div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="qty">Quantity</label>
                        <input type="number" min="1" wire:model.live="productQty" class="form-control" placeholder="Quantity">
                    </div>
                </div>
                <div class="col-12 col-md-6 d-flex align-items-end">
                    @if ($selectedProduct && $selectedPlai && $productQty > 0 && $selectedCustomer)
                        <div class="form-group w-100">
                            <button type="button" wire:click="addProduct" class="btn btn-primary btn-block">
                                <i class="fa fa-plus"></i> Add Product
                            </button>
                        </div>
                    @endif
                </div>
            </div>

            @if($selectedProduct && $selectedPlai && ($width_in_feet > 0 || $width_in_inches > 0) && ($height_in_feet > 0 || $height_in_inches > 0))
                <div class="alert alert-info">
                    <small>
                        <strong>Preview:</strong> 
                        Square Feet: {{ number_format($this->totalSquareFeet(), 2) }} | 
                        Price per sqft: Rs {{ number_format($plais->find($selectedPlai)->price ?? 0, 2) }} | 
                        Total: Rs {{ number_format($this->totalSquareFeet() * ($plais->find($selectedPlai)->price ?? 0) * $productQty, 2) }}
                    </small>
                </div>
            @endif
        </div>
    </div>

    <!-- Selected Products Table -->
    @if(count($selectedProducts) > 0)
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="mb-0">Selected Products</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm">
                        <thead class="table-light">
                            <tr>
                                <th>Product</th>
                                <th>Dimensions</th>
                                <th>Sq Ft</th>
                                <th>Qty</th>
                                <th>Rate/Sqft</th>
                                <th>Total</th>
                                <th width="80px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($selectedProducts as $index => $product)
                                <tr>
                                    <td>{{ $product['name'] }}</td>
                                    <td>
                                        {{ $product['width_in_feet'] }}'{{ $product['width_in_inches'] }}" × 
                                        {{ $product['height_in_feet'] }}'{{ $product['height_in_inches'] }}"
                                    </td>
                                    <td>{{ number_format($product['total'] / ($product['price'] * $product['qty']), 2) }}</td>
                                    <td>{{ $product['qty'] }}</td>
                                    <td>Rs {{ number_format($product['price'], 2) }}</td>
                                    <td>Rs {{ number_format($product['total'], 2) }}</td>
                                    <td>
                                        <button type="button" wire:click="removeProduct({{ $product['id'] }})"
                                                class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

    <!-- Invoice Totals and Final Details -->
    @if(count($selectedProducts) > 0)
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="mb-0">Invoice Details</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="discount">Discount Amount</label>
                            <input type="number" wire:model.live="discount" name="discount" id="discount" 
                                   class="form-control" placeholder="Enter Discount Amount" min="0" step="0.01">
                        </div>

                        <div class="form-group">
                            <label for="advance">Advance Payment</label>
                            <input type="number" wire:model.live="advance" name="advance" id="advance" 
                                   class="form-control" placeholder="Enter Advance Payment" min="0" step="0.01">
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6 class="card-title">Invoice Summary</h6>
                                <div class="d-flex justify-content-between">
                                    <span>Subtotal:</span>
                                    <span>Rs {{ number_format($without_discounted_amount, 2) }}</span>
                                </div>
                                @if ($discounted_amount > 0)
                                    <div class="d-flex justify-content-between text-danger">
                                        <span>Discount:</span>
                                        <span>- Rs {{ number_format($discounted_amount, 2) }}</span>
                                    </div>
                                    <hr class="my-2">
                                    <div class="d-flex justify-content-between">
                                        <span>After Discount:</span>
                                        <span>Rs {{ number_format($totalAmount, 2) }}</span>
                                    </div>
                                @endif
                                @if ($advance > 0)
                                    <div class="d-flex justify-content-between text-warning">
                                        <span>Advance:</span>
                                        <span>Rs {{ number_format($advance, 2) }}</span>
                                    </div>
                                    <hr class="my-2">
                                    <div class="d-flex justify-content-between font-weight-bold">
                                        <span>Balance Due:</span>
                                        <span>Rs {{ number_format($totalAmount - $advance, 2) }}</span>
                                    </div>
                                @else
                                    <hr class="my-2">
                                    <div class="d-flex justify-content-between font-weight-bold text-primary">
                                        <span>Total Amount:</span>
                                        <span>Rs {{ number_format($totalAmount, 2) }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="text-center">
            <button type="button" wire:click="createInvoice" class="btn btn-success btn-lg px-5">
                <i class="fa fa-save"></i> Create Invoice
            </button>
        </div>
    @endif

    @if(count($selectedProducts) == 0 && $selectedCustomer)
        <div class="alert alert-info text-center">
            <i class="fa fa-info-circle"></i> Please add at least one product to create an invoice.
        </div>
    @endif
</div>