<?php

namespace App\Livewire\Finance;

use App\Enums\Finance\Quantity;
use App\Enums\Finance\InvoiceType;
use App\Enums\Finance\TripType;
use App\Models\Finance\Invoice;
use App\Models\Finance\InvoiceItem;
use App\Models\Finance\InvoiceItemType;
use App\Models\Finance\InvoiceTravelExpense;
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
    public Collection $travelExpenses;
    public $updateMode = false;

    protected $listeners = ['setReceiverData', 'removeInput', 'removeTravelExpense'];

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
        $travelExpenses = collect($this->invoice->invoiceTravelExpenses->toArray());

        $this->fill(['inputs' => $invoiceItems, 'travelExpenses' => $travelExpenses]);
    }

    /*
     * parameter: $employer -> must be the same defined in medwork.js file
     */
    public function setReceiverData($employer): void
    {
        $this->invoiceManageForm->receiver_name = $employer['name'] ?? null;
        $this->invoiceManageForm->receiver_contact_person = $employer['contact_person'] ?? null;
        $this->invoiceManageForm->receiver_address = $employer['address'] ?? null;
        $this->invoiceManageForm->receiver_street = $employer['street'] ?? null;
        $this->invoiceManageForm->receiver_house_number = $employer['house_number'] ?? null;
        $this->invoiceManageForm->receiver_postcode = $employer['postcode'] ?? null;
        $this->invoiceManageForm->receiver_city = $employer['city'] ?? null;
        $this->invoiceManageForm->receiver_phone = $employer['phone'] ?? null;
        $this->invoiceManageForm->receiver_mobile = $employer['mobile'] ?? null;
        $this->invoiceManageForm->receiver_email = $employer['email'] ?? null;
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

    public function addTravelExpense(): void
    {
        $this->travelExpenses->push(['id' => 0]);
        $this->dispatch('invoiceTravelExpenseAdded', lastIndex: $this->travelExpenses->keys()->last());
    }

    public function removeTravelExpense($key): void
    {
        $itemToDelete = $this->travelExpenses->get($key);

        // removing item from datatable.
        if($itemToDelete['id']){
            InvoiceTravelExpense::find($itemToDelete['id'])->delete();
        }

        // removing from the page
        $this->travelExpenses->pull($key);
    }

    public function copyTravelExpense($key): void
    {
        // getting the selected line
        $clone = $this->travelExpenses->get($key);

        // setting db id to null to create as new when saving
        $clone['id'] = 0;

        // pushing into the travelExpenses
        $this->travelExpenses->push($clone);
        $this->dispatch('invoiceTravelExpenseCopied', lastIndex: $this->travelExpenses->keys()->last());
    }

    private function getSectionsWithError(array $data): array
    {
        $errorsCollection = collect($this->getErrorBag())->keys();

        $data['receiverWithErrors'] = $errorsCollection->contains(function ($value, $key) {
            return \Str::contains($value, 'invoice.receiver_');
        });

        $data['inputsWithErrors'] = $errorsCollection->map(function($name) {
            return preg_replace('/[^0-9]/', '', $name);
        })->unique();

        $data['travelExpensesWithErrors'] = $errorsCollection->map(function($name) {
            return preg_replace('/[^0-9]/', '', $name);
        })->unique();

        return $data;
    }

    /**
     * @throws Throwable
     */
    public function submit($print=false): void
    {
        $this->invoiceManageForm->inputs = $this->inputs;
        $this->invoiceManageForm->travelExpenses = $this->travelExpenses;

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
        $data['itemTypeOptions']        = InvoiceItemType::all()->pluck('name', 'id')->toArray();
        $data['quantityOptions']        = Quantity::options();
        $data['invoiceTypeOptions']     = InvoiceType::options();
        $data['tripTypeOptions']        = TripType::options();

        // getting sections with error to show validation symbol in card header
        $data = $this->getSectionsWithError($data);

        return view('livewire.finance.invoice-manage-screen', $data);
    }
}
