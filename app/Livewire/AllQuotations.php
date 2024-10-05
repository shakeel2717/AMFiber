<?php

namespace App\Livewire;

use App\Models\Quotation;
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

final class AllQuotations extends PowerGridComponent
{
    use WithExport;

    public function setUp(): array
    {
        // $this->showCheckBox();

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
        return Quotation::query();
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
            ->addColumn('customer', fn(Quotation $model) => $model->party->name)
            ->addColumn('total_amount')
            ->addColumn('products', fn(Quotation $model) => $model->quotation_items->count())
            ->addColumn('created_at_formatted', fn(Quotation $model) => Carbon::parse($model->created_at)->format('d/m/Y H:i:s'));
    }

    public function columns(): array
    {
        return [
            Column::make('Id', 'id'),
            Column::make('Customer id', 'customer'),
            Column::make('Total amount', 'total_amount')
                ->sortable()
                ->searchable(),
            Column::make('Products', 'products'),

            Column::make('Created at', 'created_at')
                ->sortable(),

            Column::action('Action')
        ];
    }

    public function filters(): array
    {
        return [
            Filter::datetimepicker('created_at'),
            Filter::inputText('total_amount')->operators(['contains']),
        ];
    }

    #[\Livewire\Attributes\On('delete')]
    public function delete($rowId): void
    {
        $quotation = Quotation::find($rowId);
        $quotation->delete();

        $this->dispatch('success', status: 'Quotation deleted successfully!');
    }

    public function actions(\App\Models\Quotation $row): array
    {
        return [
            Button::add('delete')
                ->slot('Delete')
                ->id()
                ->class('btn btn-primary btn-danger btn-sm')
                ->dispatch('delete', ['rowId' => $row->id]),

            Button::add('print')
                ->slot('Print')
                ->class('btn btn-primary btn-sm')
                ->route('quotation.show', ['quotation' => $row->id]),
        ];
    }

    /*
    public function actionRules($row): array
    {
       return [
            // Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($row) => $row->id === 1)
                ->hide(),
        ];
    }
    */
}
