<?php

namespace App\Livewire\Invoice;

use App\Models\Invoice;
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

final class InvoicesTable extends PowerGridComponent
{
    use WithExport;
    use HasClearFiltersTrait;
    use HasFontAwesomeIconsTrait;
    use PowerGridOrderableColumnsTrait;

    public string $tableName = 'invoices-table';
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
     * @return Builder|Invoice
     */
    public function datasource(): Builder|Invoice
    {
        // Data Query
        return Invoice::query()->with(['services']);
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
            'services' => [
                'id', // column enabled to search
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
            ->add('invoice_number')
            ->add('name')
            ->add('invoice_date_formatted', function (Invoice $invoice){
                return formatDate($invoice->invoice_date);
            })
            ->add('service_type', function (Invoice  $invoice){
                return 'THIS IS SERVICE TYPE';
            })
            ->add('created_at')
            ->add('updated_at');
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
            Column::make('Rechnung Nr.', 'invoice_number')
                ->searchable()
                ->sortable(),
            Column::make('Name', 'name')
                ->searchable()
                ->sortable(),
            Column::make('Rechnung Datum', 'invoice_date_formatted', 'invoice_date')
                ->searchable()
                ->sortable()
                ->searchableRaw('DATE_FORMAT(invoice_date, "%d.%m.%Y") like ?'),

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
            Filter::inputText('invoice_number')->operators(['contains']),
            Filter::inputText('name')->operators(['contains']),
            Filter::datepicker('invoice_date_formatted', 'invoice_date')
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
            Button::make('edit_invoice')
                ->slot($this->editIcon()->renderIcon())
                ->class('btn btn-sm btn-offwhite btn-border-gray-2  float-start')
                ->tooltip('Invoice bearbeiten')
                ->route('invoices.edit',['invoice' => $row->id], '_self'),
            Button::make('view_invoice')
                ->slot($this->showIcon()->renderIcon())
                ->class('btn btn-sm btn-offwhite btn-border-gray-2  float-start')
                ->tooltip('Invoice anzeigen')
                ->route('invoices.show', ['invoice' => $row->id], '_self'),
            Button::make('delete_invoice')
                ->slot($this->deleteIcon()->renderIcon())
                //  ->confirm('Rechnung wirklich löschen?')
                ->tooltip('Invoice löschen')
                ->dispatch('deleteInvoice', ['id' => $row->id])
                ->class('btn btn-sm btn-danger text-white btn-outline-danger float-start'),
            Button::make('print_invoice')
                ->slot('<i class="fa-solid fa-print"></i>')
                ->class('btn btn-sm btn-offwhite btn-border-gray-2')
                ->tooltip('Rechnung drucken')
                ->route('invoices.printInvoice', ['invoice' => $row->id], '_blank'),
        ];
    }


    #[On('deleteInvoice')]
    public function deleteInvoice($id, $confirmed = false): void
    {
        if(!$confirmed){
            $this->dispatch('swal:confirm',
                method: 'deleteInvoice',
                icon: 'warning',
                text: __('Achtung! Are you sure?'),
                params: ['id' => $id, 'confirmed'=>true],
                title: __('Bitte bestätigen'),
                confirmButtonText: __('Fortfahren')
            );
            return;
        }

        $invoice = Invoice::findOrFail($id);
        $invoiceNumber = $invoice->invoice_number;

        $invoice->services()->delete();
        $invoice->delete();

        $this->dispatch('toast:alert', message: 'Rechnung Nr. ' . $invoiceNumber . ' wurde erfolgreich gelöcht!', title: 'Success', status: 1);
    }
}
