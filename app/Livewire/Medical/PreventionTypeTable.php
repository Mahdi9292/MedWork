<?php

namespace App\Livewire\Medical;

use App\Models\Medical\PreventionType;
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

final class PreventionTypeTable extends PowerGridComponent
{
    use WithExport;
    use HasClearFiltersTrait;
    use HasFontAwesomeIconsTrait;
    use PowerGridOrderableColumnsTrait;

    public string $tableName = 'medical-prevention-type-table';
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
            PowerGrid::exportable(fileName: 'Rechnungen')
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
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
     * @return Builder|PreventionType
     */
    public function datasource(): Builder|PreventionType
    {
        // Data Query
        return PreventionType::query();
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
            ->add('created_at')
            ->add('updated_at_formatted', function (PreventionType $preventionType){
                return formatDate($preventionType->updated_at);
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
            Button::make('edit_preventionType')
                ->slot($this->editIcon()->renderIcon())
                ->class('btn btn-sm btn-offwhite btn-border-gray-2  float-start')
                ->tooltip('PreventionType bearbeiten')
                ->route('medical.preventionTypes.edit',['preventionType' => $row->id], '_self'),
            Button::make('view_preventionType')
                ->slot($this->showIcon()->renderIcon())
                ->class('btn btn-sm btn-offwhite btn-border-gray-2  float-start')
                ->tooltip('PreventionType anzeigen')
                ->route('medical.preventionTypes.show', ['preventionType' => $row->id], '_self'),
            Button::make('delete_preventionType')
                ->slot($this->deleteIcon()->renderIcon())
                //  ->confirm('Rechnung wirklich löschen?')
                ->tooltip('PreventionType löschen')
                ->dispatch('deletePreventionType', ['id' => $row->id])
                ->class('btn btn-sm btn-danger text-white btn-outline-danger float-start'),
        ];
    }


    #[On('deletePreventionType')]
    public function deletePreventionType($id, $confirmed = false): void
    {
        if(!$confirmed){
            $this->dispatch('swal:confirm',
                method: 'deletePreventionType',
                icon: 'warning',
                text: __('Achtung! Are you sure?'),
                params: ['id' => $id, 'confirmed'=>true],
                title: __('Bitte bestätigen'),
                confirmButtonText: __('Fortfahren')
            );
            return;
        }

        $preventionType = PreventionType::findOrFail($id);
        $preventionTypeName = $preventionType->name;

        $preventionType->delete();

        $this->dispatch('toast:alert', message: 'Vorsorgeart ' . $preventionTypeName . ' wurde erfolgreich gelöcht!', title: 'Success', status: 1);
    }

    // Rules
    public function actionRules(): array
    {
        return [
            Rule::button('edit_preventionType')
                ->when(fn() => !Auth::user()->can(config('perm.medical.preventionType.update')))
                ->hide(),

            Rule::button('view_preventionType')
                ->when(fn() => !Auth::user()->can(config('perm.medical.preventionType.view')))
                ->hide(),

            Rule::button('delete_preventionType')
                ->when(fn() => !Auth::user()->can(config('perm.medical.preventionType.delete')))
                ->hide(),
        ];
    }
}
