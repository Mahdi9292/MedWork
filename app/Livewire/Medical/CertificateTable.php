<?php

namespace App\Livewire\Medical;

use App\Models\Medical\Certificate;
use App\Services\InvoiceService;
use App\Traits\HasClearFiltersTrait;
use App\Traits\HasFontAwesomeIconsTrait;
use App\Traits\PowerGridOrderableColumnsTrait;
use Exception;
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
use Mpdf\MpdfException;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;

use PowerComponents\LivewirePowerGrid\Traits\{WithExport};

final class CertificateTable extends PowerGridComponent
{
    use WithExport;
    use HasClearFiltersTrait;
    use HasFontAwesomeIconsTrait;
    use PowerGridOrderableColumnsTrait;

    public string $tableName = 'medical-certificate-table';
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
            PowerGrid::exportable(fileName: 'Bescheinigungen')
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
     * @return Builder|Certificate
     */
    public function datasource(): Builder|Certificate
    {
        // Data Query
        return Certificate::query()->with(['preventions', 'preventions.activity']);
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
        return [
            'preventions' => [
                'id', // column enabled to search
                'activity' => [
                    'id', // column enabled to search
                ],
            ],

        ];
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
            ->add('birthday_formatted', function (Certificate $certificate){
                return formatDate($certificate->birthday);
            })
            ->add('issue_date_formatted', function (Certificate $certificate){
                return formatDate($certificate->issue_date);
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

            Column::make('Bescheinigung Nr.', 'certificate_number')
                ->searchable()
                ->sortable(),

            Column::make('Patient Nachname', 'last_name')
                ->searchable()
                ->sortable(),

            Column::make('Geburtsdatum', 'birthday_formatted', 'birthday')
                ->searchable()
                ->sortable()
                ->searchableRaw('DATE_FORMAT(birthday, "%d.%m.%Y") like ?'),

            Column::make('Bescheinigung Datum', 'issue_date_formatted', 'issue_date')
                ->searchable()
                ->sortable()
                ->searchableRaw('DATE_FORMAT(issue_date, "%d.%m.%Y") like ?'),

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
            Filter::inputText('certificate_number')->operators(['contains']),
            Filter::inputText('last_name')->operators(['contains']),
            Filter::datepicker('birthday_formatted', 'birthday')
                ->params([
                'enableTime' => false,
                'dateFormat' => 'd.m.Y',
            ]),
            Filter::datepicker('issue_date_formatted', 'issue_date')
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
            Button::make('edit_certificate')
                ->slot($this->editIcon()->renderIcon())
                ->class('btn btn-sm btn-offwhite btn-border-gray-2  float-start')
                ->tooltip('Certificate bearbeiten')
                ->route('medical.certificates.edit',['certificate' => $row->id], '_self'),

        //    Button::make('view_certificate')
        //        ->slot($this->showIcon()->renderIcon())
        //        ->class('btn btn-sm btn-offwhite btn-border-gray-2  float-start')
        //        ->tooltip('Certificate anzeigen')
        //        ->route('medical.certificates.show', ['certificate' => $row->id], '_self'),

            Button::make('print_certificate')
                ->slot('<i class="fa-solid fa-print"></i>')
                ->class('btn btn-sm btn-offwhite btn-border-gray-2')
                ->tooltip('Rechnung drucken')
                ->route('medical.printCertificate', ['certificate' => $row->id], '_blank'),

            Button::make('delete_certificate')
                ->slot($this->deleteIcon()->renderIcon())
                //  ->confirm('Rechnung wirklich löschen?')
                ->tooltip('Certificate löschen')
                ->dispatch('deleteCertificate', ['id' => $row->id])
                ->class('btn btn-sm btn-danger text-white btn-outline-danger float-start'),
        ];
    }


    #[On('deleteCertificate')]
    public function deleteCertificate($id, $confirmed = false): void
    {
        if(!$confirmed){
            $this->dispatch('swal:confirm',
                method: 'deleteCertificate',
                icon: 'warning',
                text: __('Achtung! Are you sure?'),
                params: ['id' => $id, 'confirmed'=>true],
                title: __('Bitte bestätigen'),
                confirmButtonText: __('Fortfahren')
            );
            return;
        }

        $certificate = Certificate::findOrFail($id);
        $certificateNumber = $certificate->certificate_number;

        $certificate->preventions()->delete();
        $certificate->delete();

        $this->dispatch('toast:alert', message: 'Besheinigung Nr. ' . $certificateNumber . ' wurde erfolgreich gelöcht!', title: 'Success', status: 1);
    }

    // Rules
    public function actionRules($certificate): array
    {
        return [
            Rule::button('edit_certificate')
                ->when(fn() => !Auth::user()->can(config('perm.invoice.update')))
                ->hide(),

        //    Rule::button('view_certificate')
        //        ->when(fn() => !Auth::user()->can(config('perm.invoice.view')))
        //        ->hide(),

            Rule::button('delete_certificate')
                ->when(fn() => !Auth::user()->can(config('perm.invoice.delete')))
                ->hide(),
        ];
    }
}
