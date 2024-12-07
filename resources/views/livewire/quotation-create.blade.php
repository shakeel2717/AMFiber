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
                    placeholder="Search by name or phone"
                    wire:model.debounce.500ms="customerSearch">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button" wire:click="clearcustomerSearch">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="customer_id">Select Customer</label>
            <select wire:model="selectedCustomer" name="customer_id" id="customer_id" class="js-select2 form-control">
                <option value="">Select a Customer</option>
                @foreach ($customers as $customer)
                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                @endforeach
            </select>
        </div>

        <fieldset class="border p-2 rounded">
            <legend>Item Details:</legend>
            <div class="form-group">
                <label>Width and Height</label>
                <div class="input-group">
                    <input type="text" name="width" id="width" wire:model.live="width" class="form-control"
                        placeholder="Enter Width">
                    <input type="text" name="height" id="height" wire:model.live="height" class="form-control"
                        placeholder="Enter height">
                </div>
            </div>
            <div class="form-group">
                <label for="specification">Specification</label>
                <input type="text" wire:model.live="specification" name="specification" id="specification"
                    class="form-control" placeholder="Enter Specifications">
            </div>
            <div class="form-group">
                <label for="truss">Truss Pipe</label>
                <input type="text" wire:model.live="truss" name="truss" id="truss" class="form-control"
                    placeholder="Enter Truss Pipe">
            </div>
            <div class="form-group">
                <label for="shed">Shed Pipe</label>
                <input type="text" wire:model.live="shed" name="shed" id="shed" class="form-control"
                    placeholder="Enter Shed Pipe">
            </div>
            <div class="form-group">
                <label for="piller">Pillar Pipe</label>
                <input type="text" wire:model.live="piller" name="piller" id="piller" class="form-control"
                    placeholder="Enter Pillar Pipe">
            </div>
            <div class="form-group">
                <label for="thickness">Thickness (mm)</label>
                <input type="text" wire:model.live="thickness" name="thickness" id="thickness" class="form-control"
                    placeholder="Enter Thickness">
            </div>
            <div class="form-group">
                <label for="price">Price per Square Foot</label>
                <input type="text" wire:model.live="price" name="price" id="price" class="form-control"
                    placeholder="Enter Price">
            </div>
            <div class="input-group">
                <div class="input-group-append">
                    <button type="button" wire:click="addItem" class="btn btn-primary">Add Item</button>
                </div>
            </div>
        </fieldset>

        <div class="table-responsive mt-3">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Size</th>
                        <th>Specification</th>
                        <th>Truss Pipe</th>
                        <th>Shed Pipe</th>
                        <th>Pillar Pipe</th>
                        <th>Thickness</th>
                        <th>Total</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($selectedItems as $item)
                    <tr>
                        <td>{{ $item['size'] }}</td>
                        <td>{{ $item['specification'] }}</td>
                        <td>{{ $item['truss'] }}</td>
                        <td>{{ $item['shed'] }}</td>
                        <td>{{ $item['piller'] }}</td>
                        <td>{{ $item['thickness'] }}</td>
                        <td>Rs {{ number_format($item['total'], 2) }}</td>
                        <td>
                            <button type="button" wire:click="removeItem('{{ $item['id'] }}')" class="btn btn-danger btn-sm">Remove</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="form-group">
            <h4>Total Amount: Rs {{ number_format($totalAmount, 2) }}</h4>
        </div>

        <button type="button" wire:click="createQuotation" class="btn btn-primary">Save Quotation</button>
    </form>
</div>