<?php

namespace App\Livewire\Medical;

use App\Models\Medical\Comment;
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

final class CommentTable extends PowerGridComponent
{
    use WithExport;
    use HasClearFiltersTrait;
    use HasFontAwesomeIconsTrait;
    use PowerGridOrderableColumnsTrait;

    public string $tableName = 'medical-comment-table';
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
            PowerGrid::exportable(fileName: 'Kommentare')
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
     * @return Builder|Comment
     */
    public function datasource(): Builder|Comment
    {
        // Data Query
        return Comment::query();
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
            ->add('type')
            ->add('content')
            ->add('created_at_formatted', function (Comment $comment){
                return formatDate($comment->created_at);
            })
            ->add('updated_at_formatted', function (Comment $comment){
                return formatDate($comment->updated_at);
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

            Column::make('TYP', 'type')
                ->searchable()
                ->sortable(),

            Column::make('Inhalt', 'content')
                ->contentClasses('text-wrap')
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
            Filter::inputText('type')->operators(['contains']),
            Filter::inputText('content')->operators(['contains']),
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
            Button::make('edit_comment')
                ->slot($this->editIcon()->renderIcon())
                ->class('btn btn-sm btn-offwhite btn-border-gray-2  float-start')
                ->tooltip('Kommentar bearbeiten')
                ->route('medical.comments.edit',['comment' => $row->id], '_self'),
            Button::make('view_comment')
                ->slot($this->showIcon()->renderIcon())
                ->class('btn btn-sm btn-offwhite btn-border-gray-2  float-start')
                ->tooltip('Kommentar anzeigen')
                ->route('medical.comments.show', ['comment' => $row->id], '_self'),
            Button::make('delete_comment')
                ->slot($this->deleteIcon()->renderIcon())
                //  ->confirm('Rechnung wirklich löschen?')
                ->tooltip('Kommentar löschen')
                ->dispatch('deleteComment', ['id' => $row->id])
                ->class('btn btn-sm btn-danger text-white btn-outline-danger float-start'),
        ];
    }


    #[On('deleteComment')]
    public function deleteComment($id, $confirmed = false): void
    {
        if(!$confirmed){
            $this->dispatch('swal:confirm',
                method: 'deleteComment',
                icon: 'warning',
                text: __('Achtung! Are you sure?'),
                params: ['id' => $id, 'confirmed'=>true],
                title: __('Bitte bestätigen'),
                confirmButtonText: __('Fortfahren')
            );
            return;
        }

        $comment = Comment::findOrFail($id);
        $comment->delete();

        $this->dispatch('toast:alert', message: 'Kommentar wurde erfolgreich gelöcht!', title: 'Success', status: 1);
    }

    // Rules
    public function actionRules(): array
    {
        return [
            Rule::button('edit_comment')
                ->when(fn() => !Auth::user()->can(config('perm.medical.comment.update')))
                ->hide(),

            Rule::button('view_comment')
                ->when(fn() => !Auth::user()->can(config('perm.medical.comment.view')))
                ->hide(),

            Rule::button('delete_comment')
                ->when(fn() => !Auth::user()->can(config('perm.medical.comment.delete')))
                ->hide(),
        ];
    }
}
