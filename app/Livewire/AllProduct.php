<?php

namespace App\Livewire;

use App\Models\Product;
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

final class AllProduct extends PowerGridComponent
{
    use WithExport;

    public $name;
    public $description;

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
        return Product::query();
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
            ->addColumn('name_lower', fn(Product $model) => strtolower(e($model->name)))

            ->addColumn('description')
            ->addColumn('image_url', function (Product $model) {
                if ($model->image) {
                    return '<img src="' . asset('products/' . $model->image) . '" width="100" height="100">';
                } else {
                    return "No Image";
                }
            })
            ->addColumn('price')
            ->addColumn('created_at_formatted', fn(Product $model) => Carbon::parse($model->created_at)->format('d/m/Y H:i:s'));
    }

    public function columns(): array
    {
        return [
            // Column::make('Id', 'id'),
            Column::make('Name', 'name')
                ->sortable()
                ->editOnClick()
                ->searchable(),

            Column::make('Description', 'description')
                ->sortable()
                ->editOnClick()
                ->searchable(),

            Column::make('Image', 'image_url'),

            Column::make('Created at', 'created_at')
                ->sortable(),

            Column::action('Action')
        ];
    }

    public function filters(): array
    {
        return [
            Filter::inputText('name')->operators(['contains']),
            Filter::inputText('description')->operators(['contains']),
            Filter::inputText('image')->operators(['contains']),
            Filter::inputText('price')->operators(['contains']),
            Filter::datetimepicker('created_at'),
        ];
    }

    public function onUpdatedEditable(string|int $id, string $field, string $value): void
    {
        Product::query()->find($id)->update([
            $field => e($value),
        ]);
    }

    #[\Livewire\Attributes\On('delete')]
    public function delete($rowId): void
    {
        $product = Product::find($rowId);
        $product->delete();

        $this->dispatch('success', status: 'Product Deleted successfully!');
    }

    public function actions(\App\Models\Product $row): array
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
