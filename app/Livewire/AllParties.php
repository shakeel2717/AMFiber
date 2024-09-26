<?php

namespace App\Livewire;

use App\Models\Party;
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

final class AllParties extends PowerGridComponent
{
    use WithExport;

    public $name;
    public $phone;
    public $address;

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
        return Party::query();
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function addColumns(): PowerGridColumns
    {
        return PowerGrid::columns()
            ->addColumn('id')
            ->addColumn('name')

            /** Example of custom column using a closure **/
            ->addColumn('balance', fn(Party $model) => number_format($model->balance(), 2))

            ->addColumn('phone')
            ->addColumn('address')
            ->addColumn('type')
            ->addColumn('created_at_formatted', fn(Party $model) => Carbon::parse($model->created_at)->format('d/m/Y H:i:s'));
    }

    public function columns(): array
    {
        return [
            // Column::make('Id', 'id'),
            Column::make('Name', 'name')
                ->sortable()
                ->editOnClick()
                ->searchable(),

            Column::make('Balance', 'balance'),

            Column::make('Phone', 'phone')
                ->sortable()
                ->editOnClick()
                ->searchable(),

            Column::make('Address', 'address')
                ->sortable()
                ->editOnClick()
                ->searchable(),

            Column::make('Type', 'type')
                ->sortable()
                ->searchable(),

            Column::make('Created at', 'created_at_formatted', 'created_at')
                ->sortable(),

            Column::action('Action')
        ];
    }

    public function filters(): array
    {
        return [
            Filter::inputText('name')->operators(['contains']),
            Filter::inputText('phone')->operators(['contains']),
            Filter::inputText('address')->operators(['contains']),
            Filter::inputText('type')->operators(['contains']),
            Filter::datetimepicker('created_at'),
        ];
    }

    public function onUpdatedEditable(string|int $id, string $field, string $value): void
    {
        Party::query()->find($id)->update([
            $field => e($value),
        ]);
    }

    // #[\Livewire\Attributes\On('edit')]
    // public function edit($rowId): void
    // {
    //     $this->js('alert('.$rowId.')');
    // }

    public function actions(\App\Models\Party $row): array
    {
        return [
            Button::add('statement')
                ->slot('Print Statement')
                ->class('btn btn-primary btn-sm')
                ->route('party.statement', ['party' => $row->id]),
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
