<?php

namespace App\Livewire\Finance;

use App\Enums\Finance\Quantity;
use App\Enums\Finance\InvoiceItemType;
use App\Models\Finance\Invoice;
use App\Models\Finance\InvoiceItem;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;
use Throwable;

class InvoiceManageScreen extends Component
{
    use WithFileUploads;

    public Invoice $invoice;
    public InvoiceManageForm $invoiceManageForm;
    public Collection $inputs;
    public $updateMode = false;

    protected $listeners = ['setReceiverData', 'removeInput'];

    private const string nullable_MESSAGE = 'Dieses Feld muss ausgefüllt werden.';
    private const string NUMERIC_MESSAGE = 'Dieses Feld muss eine Zahl sein.';
    private const string nullable_WITH_MESSAGE = 'Dieses Feld muss ausgefüllt werden, wenn ein Genehmiger ausgewählt wurde.';

    protected array $messages = [

    ];

    public function mount($invoice): void
    {
        $this->invoiceManageForm->setInvoice($invoice);
        $this->loadItems();
    }

    private function loadItems(): void
    {
        $invoiceItems = collect($this->invoice->invoiceItems->toArray());

        $this->fill(['inputs' => $invoiceItems]);
    }

    public function setReceiverData($receiver): void
    {
        $this->invoiceManageForm->receiver_name = $receiver['name'] ?? null;
        $this->invoiceManageForm->receiver_contact_person = $receiver['contact_person'] ?? null;
        $this->invoiceManageForm->receiver_address = $receiver['address'] ?? null;
        $this->invoiceManageForm->receiver_street = $receiver['street'] ?? null;
        $this->invoiceManageForm->receiver_house_number = $receiver['house_number'] ?? null;
        $this->invoiceManageForm->receiver_postcode = $receiver['postcode'] ?? null;
        $this->invoiceManageForm->receiver_city = $receiver['city'] ?? null;
        $this->invoiceManageForm->receiver_phone = $receiver['phone'] ?? null;
        $this->invoiceManageForm->receiver_mobile = $receiver['mobile'] ?? null;
        $this->invoiceManageForm->receiver_email = $receiver['mail'] ?? null;
    }

    public function addInput(): void
    {
        $this->inputs->push(['id' => 0]);
        $this->dispatch('invoiceItemAdded', lastIndex: $this->inputs->keys()->last());
    }

    public function removeInput($key): void
    {
        $itemToDelete = $this->inputs->get($key);

        // removing item from datatable.
        if($itemToDelete['id']){
            InvoiceItem::find($itemToDelete['id'])->delete();
        }

        // removing from the page
        $this->inputs->pull($key);
    }

    public function copyInput($key): void
    {
        // getting the selected line
        $clone = $this->inputs->get($key);

        // setting db id to null to create as new when saving
        $clone['id'] = 0;

        // pushing into the inputs
        $this->inputs->push($clone);
        $this->dispatch('invoiceItemCopied', lastIndex: $this->inputs->keys()->last());
    }

    public function getFieldID($key, $name, $prefix='inputs'): string
    {
        return join(".", [$prefix, $key, $name]);
    }

    private function getSectionsWithError(array $data): array
    {
        $errorsCollection = collect($this->getErrorBag())->keys();

        $data['inputsWithErrors'] = $errorsCollection->map(function($name) {
            return preg_replace('/[^0-9]/', '', $name);
        })->unique();

        $data['receiverWithErrors'] = $errorsCollection->contains(function ($value, $key) {
            return \Str::contains($value, 'invoice.receiver_');
        });
        return $data;
    }

    /**
     * @throws Throwable
     */
    public function submit($print=false): void
    {
        $this->invoiceManageForm->inputs = $this->inputs;

        if(!$this->updateMode){
            $this->invoiceManageForm->store();
            $this->invoice = $this->invoiceManageForm->invoice;

            $this->redirect(route('finance.invoices.edit', $this->invoice));
        }else{
            $this->invoiceManageForm->update();
        }

        // success message
        $this->dispatch('toast:alert', message: 'Speichern erfolgreich!', title: 'Success', status: 1);

        // refreshing the data
        $this->invoice->refresh();
        $this->loadItems();

        // if save and print was clicked
        if($print){
            $this->redirect(route('finance.printInvoice', $this->invoice));
        }
    }

    public function render(): view
    {
        // Errors
        if(collect($this->getErrorBag())->count()>0){
            $this->dispatch('toast:alert', message: 'Please fix errors to save!', title: 'Error', status: 2);
        }

        // Dropdown options
        $data['serviceTypeOptions']    = InvoiceItemType::options();
        $data['quantityOptions']       = Quantity::options();

        // getting sections with error to show validation symbol in card header
        $data = $this->getSectionsWithError($data);

        return view('livewire.invoice.invoice-manage-screen', $data);
    }
}
