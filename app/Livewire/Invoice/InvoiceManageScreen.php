<?php

namespace App\Livewire\Invoice;

use App\Enums\Invoice\ServiceType;
use App\Livewire\Invoice\Forms\InvoiceManageForm;
use App\Models\Invoice;
use App\Models\InvoiceService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\Features\SupportEvents\Event;
use Livewire\Features\SupportRedirects\Redirector;
use Livewire\WithFileUploads;

class InvoiceManageScreen extends Component
{
    use WithFileUploads;

    public Invoice $invoice;

    public InvoiceManageForm $invoiceManageForm;

    public $updateMode = false;

    public $attachments = [];

    public bool $isSubmitting = false;

    protected $listeners = ['removeInput'];

    // region: main functions
    public function mount($invoice): void
    {
        if (session()->has('cloned_invoice')) {
            $cloned = session('cloned_invoice');

            // Create a fake Invoice instance populated with cloned attributes
            $invoice = new Invoice;
            $invoice->fill($cloned);
        }
        $this->InvoiceManageForm->setInvoice($invoice);
    }

    public function dehydrate(): void
    {
        // work around to keep tom select alive
        $this->dispatch('re-init-alpine-component');
    }

    private function reload(): void
    {
        $this->invoice->refresh();
    }

    public function submit(): RedirectResponse|Redirector|Event|null
    {
        // CREATE
        if (! $this->updateMode) {
            return $this->processCreate();
        }

        // UPDATE
        $this->processUpdate();

        return null;
    }

    // endregion

    // region: process functions
    private function getSectionsWithError(array $data): array
    {
        $errorsCollection = collect($this->getErrorBag())->keys();
        $data['inputsWithErrors'] = $errorsCollection->map(function ($name) {
            return preg_replace('/[^0-9]/', '', $name);
        })->unique();

        return $data;
    }

    #[On('processCreate')]
    public function processCreate(): RedirectResponse|Redirector|Event|null
    {
        // Prevent double submission
        if ($this->isSubmitting) {
            return null;
        }

        // block the Submition
        $this->isSubmitting = true;

        // store the data
        if (! $this->InvoiceManageForm->store()) {
            $this->isSubmitting = false;
            $this->dispatch('toast:alert', message: __('Fehler!'), title: 'Fehler', status: 2);

            return null;
        }

        // reset the invoice
        $this->invoice = $this->InvoiceManageForm->invoice;

        return redirect()->route('invoices.edit', $this->invoice)->with('success', __('Speichern erfolgreich'));
    }

    public function processUpdate(): RedirectResponse|Redirector|Event|null
    {
        if (! $this->InvoiceManageForm->update()) {
            $this->dispatch('toast:alert', message: __('Update Fehler.'), title: 'Fehler', status: 2);

            return null;
        }

        // reset the invoice
        $this->invoice = $this->InvoiceManageForm->invoice;
        $this->invoice->refresh();

        Session::flash('success', __('Speichern erfolgreich.'));
        $this->dispatch('toast:alert', message: 'Speichern erfolgreich!', title: 'Success', status: 1);
        $this->isSubmitting = false;

        return null;
    }


    // endregion

    # region: Input functions

    public function addInput(): void
    {
        $this->invoiceManageForm->inputs->push(['id' => 0]);
        $this->dispatch('offerLineAdded', lastIndex: $this->invoiceManageForm->inputs->keys()->last());
    }

    public function removeInput($key): void
    {
        $itemToDelete = $this->invoiceManageForm->inputs->get($key);

        // removing item from datatable.
        if($itemToDelete['id']){
            InvoiceService::find($itemToDelete['id'])->delete();
        }

        // removing from the page
        $this->inputs->pull($key);
    }

    public function copyInput($key): void
    {
        // getting the selected line
        $clone = $this->invoiceManageForm->inputs->get($key);

        // setting db id to null to create as new when saving
        $clone['id'] = 0;

        // pushing into the inputs
        $this->invoiceManageForm->inputs->push($clone);
        $this->dispatch('invoiceServiceCopied', lastIndex: $this->invoiceManageForm->inputs->keys()->last());
    }

    public function getFieldID($key, $name, $prefix='inputs'): string
    {
        return join(".", [$prefix, $key, $name]);
    }
    #endregion

    public function render(): view
    {
        // Dropdown options
        $data['serviceTypeOptions']    = ServiceType::options();


        // Errors
        if (collect($this->getErrorBag())->count() > 0) {
            $this->isSubmitting = false;
            $this->dispatch('toast:alert', message: 'Please fix errors to save!', title: 'Error', status: 2);
        }

        // getting sections with error to show validation symbol in card header
        $data = $this->getSectionsWithError($data);

        return view('livewire.invoice-book.screens.invoice-manage-screen', $data);
    }
}
