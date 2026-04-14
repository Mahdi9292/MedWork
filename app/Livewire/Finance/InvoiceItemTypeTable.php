<?php

namespace App\Livewire\Finance;

use App\Models\Finance\InvoiceItemType;
use App\Traits\HasClearFiltersTrait;
use App\Traits\HasFontAwesomeIconsTrait;
use App\Traits\PowerGridOrderableColumnsTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use PowerComponents\LivewirePowerGrid\{Button,
    Column,
    Components\SetUp\Exportable,
    Facades\Filter,
    Facades\Rule,
    PowerGridComponent,
    PowerGridFields};
use Livewire\Attributes\On;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;

use PowerComponents\LivewirePowerGrid\Traits\{WithExport};

final class InvoiceItemTypeTable extends PowerGridComponent
{
    use WithExport;
    use HasClearFiltersTrait;
    use HasFontAwesomeIconsTrait;
    use PowerGridOrderableColumnsTrait;

    public string $tableName = 'finance-invoice-item-type-table';
    public string $sortField = 'id';
    public string $sortDirection = 'desc';


    /*
    |--------------------------------------------------------------------------
    |  Features Setup
    |--------------------------------------------------------------------------
    | Setup Table's general features
    |
    */
    public function setUp(): array
    {
        $this->showCheckBox();
        $this->persist(['columns', 'filters']);

        return [
            PowerGrid::exportable(fileName: 'Leistungstype')
                ->type(Exportable::TYPE_XLS),
            PowerGrid::header()
                ->showSearchInput()
                ->showToggleColumns(),
            PowerGrid::footer()
                ->showPerPage(10, [10, 25, 50, 100])
                ->showRecordCount(),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    |  Datasource
    |--------------------------------------------------------------------------
    | Provides data to your Table using a Model or Collection
    |
    */

    /**
     * PowerGrid datasource.
     *
     * @return Builder|InvoiceItemType
     */
    public function datasource(): Builder|InvoiceItemType
    {
        // Data Query
        return InvoiceItemType::query();
    }

    /*
    |--------------------------------------------------------------------------
    |  Relationship Search
    |--------------------------------------------------------------------------
    | Configure here relationships to be used by the Search and Table Filters.
    |
    */

    /**
     * Relationship search.
     *
     * @return array<string, array<int, string>>
     */
    public function relationSearch(): array
    {
        // Relational columns enabled to search
        return [];
    }

    /*
    |--------------------------------------------------------------------------
    |  Add Column
    |--------------------------------------------------------------------------
    | Make Datasource fields available to be used as columns.
    | You can pass a closure to transform/modify the data.
    |
    | ❗ IMPORTANT: When using closures, you must escape any value coming from
    |    the database using the `e()` Laravel Helper function.
    |
    */
    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('updated_at_formatted', function (InvoiceItemType $invoiceItemType){
                return formatDate($invoiceItemType->updated_at);
            });
    }

    /*
    |--------------------------------------------------------------------------
    |  Include Columns
    |--------------------------------------------------------------------------
    | Include the columns added columns, making them visible on the Table.
    | Each column can be configured with properties, filters, actions...
    |
    */

    /**
     * PowerGrid Columns.
     *
     * @return array<int, Column>
     */
    public function columns(): array
    {
        return [
            Column::make('NR', 'id')
                ->headerAttribute('', 'width: 200px;')
                ->bodyAttribute('', 'width: 100px;'),
            Column::make('Typ', 'name')
                ->searchable()
                ->sortable(),
            Column::make('Kommentar', 'comment')
                ->searchable()
                ->sortable(),
            Column::make('Letzte Änderung', 'updated_at_formatted', 'updated_at')
                ->searchable()
                ->sortable()
                ->searchableRaw('DATE_FORMAT(updated_at, "%d.%m.%Y") like ?'),

            Column::action('Action')->headerAttribute('text-center', '')->bodyAttribute('', 'width: 150px;'),
        ];
    }

    /**
     * PowerGrid Filters.
     *
     * @return array<int, Filter>
     */
    public function filters(): array
    {
        return [
            Filter::inputText('id')->operators(['contains']),
            Filter::inputText('name')->operators(['contains']),
            Filter::inputText('comment')->operators(['contains']),
            Filter::datepicker('updated_at_formatted', 'updated_at')
                ->params([
                'enableTime' => false,
                'dateFormat' => 'd.m.Y',
            ]),
        ];
    }

    /**
     * PowerGrid Medicine Action Buttons.
     *
     * @return array<int, Button>
     */
    public function actions($row): array
    {
        return [
            Button::make('edit_invoiceItemType')
                ->slot($this->editIcon()->renderIcon())
                ->class('btn btn-sm btn-offwhite btn-border-gray-2  float-start')
                ->tooltip('InvoiceItemType bearbeiten')
                ->route('finance.invoiceItemTypes.edit',['invoiceItemType' => $row->id], '_self'),
            Button::make('view_invoiceItemType')
                ->slot($this->showIcon()->renderIcon())
                ->class('btn btn-sm btn-offwhite btn-border-gray-2  float-start')
                ->tooltip('InvoiceItemType anzeigen')
                ->route('finance.invoiceItemTypes.show', ['invoiceItemType' => $row->id], '_self'),
            Button::make('delete_invoiceItemType')
                ->slot($this->deleteIcon()->renderIcon())
                //  ->confirm('Rechnung wirklich löschen?')
                ->tooltip('InvoiceItemType löschen')
                ->dispatch('deleteInvoiceItemType', ['id' => $row->id])
                ->class('btn btn-sm btn-danger text-white btn-outline-danger float-start'),
        ];
    }


    #[On('deleteInvoiceItemType')]
    public function deleteInvoiceItemType($id, $confirmed = false): void
    {
        if(!$confirmed){
            $this->dispatch('swal:confirm',
                method: 'deleteInvoiceItemType',
                icon: 'warning',
                text: __('Achtung! Are you sure?'),
                params: ['id' => $id, 'confirmed'=>true],
                title: __('Bitte bestätigen'),
                confirmButtonText: __('Fortfahren')
            );
            return;
        }

        $invoiceItemType = InvoiceItemType::findOrFail($id);
        $invoiceItemTypeName = $invoiceItemType->name;

        $invoiceItemType->delete();

        $this->dispatch('toast:alert', message: 'Vorsorgeart ' . $invoiceItemTypeName . ' wurde erfolgreich gelöcht!', title: 'Success', status: 1);
    }

    // Rules
    public function actionRules(): array
    {
        return [
            Rule::button('edit_invoiceItemType')
                ->when(fn() => !Auth::user()->can(config('perm.finance.invoiceItemType.update')))
                ->hide(),

            Rule::button('view_invoiceItemType')
                ->when(fn() => !Auth::user()->can(config('perm.finance.invoiceItemType.view')))
                ->hide(),

            Rule::button('delete_invoiceItemType')
                ->when(fn() => !Auth::user()->can(config('perm.finance.invoiceItemType.delete')))
                ->hide(),
        ];
    }
}
