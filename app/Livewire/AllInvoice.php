<?php

namespace App\Livewire;

use App\Models\Invoice;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridColumns;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;

final class AllInvoice extends PowerGridComponent
{
    use WithExport;

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
        return Invoice::query();
    }

    public function relationSearch(): array
    {
        return [
            "Party" => [
                'name',
                'phone',
            ]
        ];
    }

    public function addColumns(): PowerGridColumns
    {
        return PowerGrid::columns()
            ->addColumn('id')
            ->addColumn('customer', function (Invoice $model) {
                return $model->party->name;
            })
            ->addColumn('total_amount')
            ->addColumn('discount')
            ->addColumn('products', fn(Invoice $model) => $model->invoice_products->count())
            ->addColumn('created_at_formatted', fn(Invoice $model) => Carbon::parse($model->created_at)->format('d/m/Y H:i:s'));
    }

    public function columns(): array
    {
        return [
            Column::make('Id', 'id'),
            Column::make('Customer id', 'customer'),
            Column::make('Products', field: 'products'),
            Column::make('Total amount', 'total_amount')
                ->sortable()
                ->searchable(),

            Column::make('Discount', 'discount')
                ->sortable()
                ->searchable(),

            Column::make('Created at', 'created_at')
                ->sortable(),

            Column::action('Action')
        ];
    }

    public function filters(): array
    {
        return [
            Filter::datetimepicker('created_at'),
        ];
    }

    #[\Livewire\Attributes\On('delete')]
    public function delete($rowId): void
    {
        $invoice = Invoice::findOrFail($rowId);
        $invoice->delete();

        $this->dispatch('success', status: 'Invoice Deleted successfully!');
    }

    public function actions(\App\Models\Invoice $row): array
    {
        return [
            Button::add('edit')
                ->slot('Edit')
                ->class('btn btn-primary btn-sm')
                ->route('invoice.edit_product', ['invoice' => $row->id]),

            Button::add('delete')
                ->slot('Delete')
                ->id()
                ->class('btn btn-danger btn-sm')
                ->dispatch('delete', ['rowId' => $row->id]),

            Button::add('print')
                ->slot('Print')
                ->class('btn btn-primary btn-sm')
                ->route('invoice.show', ['invoice' => $row->id]),

        ];
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
