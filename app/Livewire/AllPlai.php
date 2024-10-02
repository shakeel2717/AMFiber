<?php

namespace App\Livewire;

use App\Models\Plai;
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

final class AllPlai extends PowerGridComponent
{
    use WithExport;
    public $name;
    public $price;

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
        return Plai::query();
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('name')
            ->add('price')
            ->add('created_at');
    }

    public function columns(): array
    {
        return [
            // Column::make('Id', 'id'),
            Column::make('Name', 'name')
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

    public function onUpdatedEditable(string|int $id, string $field, string $value): void
    {
        Plai::query()->find($id)->update([
            $field => e($value),
        ]);
    }

    #[\Livewire\Attributes\On('delete')]
    public function delete($rowId): void
    {
        $product = Plai::find($rowId);
        $product->delete();

        $this->dispatch('success', status: 'Plai Deleted successfully!');
    }

    public function actions(\App\Models\Plai $row): array
    {
        return [
            Button::add('delete')
                ->slot('Delete')
                ->id()
                ->class('btn btn-danger btn-sm')
                ->dispatch('delete', ['rowId' => $row->id])
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
