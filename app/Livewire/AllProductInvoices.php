<?php

namespace App\Livewire;

use App\Models\InvoiceProduct;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;

final class AllProductInvoices extends PowerGridComponent
{
    use WithExport;

    public $invoice;

    public $product_id;
    public $plai_id;
    public $qty;
    public $width_in_feet;
    public $width_in_inches;
    public $height_in_feet;
    public $height_in_inches;
    public $price;

    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            Exportable::make('export')
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            Header::make()->showSearchInput(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        return InvoiceProduct::query()->where('invoice_id', $this->invoice->id);
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('product_id')
            ->add('qty')
            ->add('invoice_id')
            ->add('plai_id')
            ->add('width_in_feet')
            ->add('width_in_inches')
            ->add('height_in_feet')
            ->add('height_in_inches')
            ->add('price')
            ->add('created_at');
    }

    public function columns(): array
    {
        return [
            // Column::make('Id', 'id'),
            Column::make('Product id', 'product_id')
                ->editOnClick(),
            // Column::make('Invoice id', 'invoice_id'),
            Column::make('Plai id', 'plai_id')
                ->editOnClick(),
            Column::make('Qty', 'qty')
                ->sortable()
                ->editOnClick()
                ->searchable(),

            Column::make('Width in feet', 'width_in_feet')
                ->sortable()
                ->editOnClick()
                ->searchable(),

            Column::make('Width in inches', 'width_in_inches')
                ->sortable()
                ->editOnClick()
                ->searchable(),

            Column::make('Height in feet', 'height_in_feet')
                ->sortable()
                ->editOnClick()
                ->searchable(),

            Column::make('Height in inches', 'height_in_inches')
                ->sortable()
                ->editOnClick()
                ->searchable(),

            Column::make('Price', 'price')
                ->sortable()
                ->editOnClick()
                ->searchable(),

            Column::make('Created at', 'created_at')
                ->sortable()
                ->searchable(),

            Column::action('Action')
        ];
    }

    public function filters(): array
    {
        return [
        ];
    }

    #[\Livewire\Attributes\On('delete')]
    public function delete($rowId): void
    {
        $invoiceProduct = InvoiceProduct::find($rowId);
        $invoiceProduct->delete();

        $this->dispatch('success', status: 'Invoice Product Deleted successfully!');
    }

    public function actions(InvoiceProduct $row): array
    {
        return [
            Button::add('delete')
                ->slot('Delete')
                ->id()
                ->class('btn btn-danger')
                ->dispatch('delete', ['rowId' => $row->id])
        ];
    }

    public function onUpdatedEditable(string|int $id, string $field, string $value): void
    {
        InvoiceProduct::query()->find($id)->update([
            $field => e($value),
        ]);
    }

    /*
    public function actionRules($row): array
    {
       return [
            // Hide button delete for ID 1
            Rule::button('delete')
                ->when(fn($row) => $row->id === 1)
                ->hide(),
        ];
    }
    */
}
