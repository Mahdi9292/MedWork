<?php

namespace App\Livewire\Finance;

use App\Models\Finance\Invoice;
use App\Rules\Currency;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Throwable;

class InvoiceManageForm extends Form
{
    public ?Invoice $invoice;

    #region: Properties

    // Invoice
    #[Validate('nullable')]
    public $invoice_number;
    #[Validate('nullable')]
    public $invoice_type;
    #[Validate('nullable|date')]
    public $issue_date;
    #[Validate('nullable')]
    public $value_added_tax;
    #[Validate('nullable')]
    public $total_amount;

    // Receiver
    #[Validate('nullable')]
    public $receiver_name;
    #[Validate('nullable')]
    public $receiver_additional_name;
    #[Validate('nullable')]
    public $receiver_street;
    #[Validate('nullable')]
    public $receiver_house_number;
    #[Validate('nullable')]
    public $receiver_city;
    #[Validate('nullable')]
    public $receiver_postcode;
    #[Validate('nullable')]
    public $receiver_phone;
    #[Validate('nullable')]
    public $receiver_email;

    // Invoice Items
    #[Validate([
        'inputs.*.item_type_id' => 'nullable',
        'inputs.*.item_type_other' => 'nullable',
        'inputs.*.serving_date' => 'nullable',
        'inputs.*.quantity' => 'nullable',
        'inputs.*.employee_name' => 'nullable',
        'inputs.*.description' => 'nullable',
        'inputs.*.unit_price' => ['nullable', new Currency],
    ])]
    public ?Collection $inputs;

    // Invoice Travel Expenses
    #[Validate([
        'travelExpenses.*.start_location' => 'nullable',
        'travelExpenses.*.destination' => 'nullable',
        'travelExpenses.*.distance' => ['nullable', new Currency],
        'travelExpenses.*.price_per_km' => ['nullable', new Currency],
        'travelExpenses.*.trip_type' => 'nullable',
        'travelExpenses.*.travel_date' => 'nullable|date'
    ])]
    public ?Collection $travelExpenses;

    #endregion

    #region: man functions
    public function setInvoice(Invoice $invoice): void
    {
        $inputs = collect($invoice->invoiceItems?->toArray());
        $travelExpenses = collect($invoice->invoiceTravelExpenses?->toArray());

        // Main
        $this->invoice = $invoice;
        $this->inputs = $inputs ?: collect();
        $this->travelExpenses = $travelExpenses ?: collect();

        // Invoice
        $this->invoice_number = $invoice->invoice_number;
        $this->invoice_type = $invoice->invoice_type;
        $this->issue_date = $invoice->issue_date ?? now();
        $this->value_added_tax = $invoice->value_added_tax;
        $this->total_amount = $invoice->total_amount ?? $invoice->getTotalGrossAmount();

        // Receiver
        $this->receiver_name = $invoice->receiver_name;
        $this->receiver_additional_name = $invoice->receiver_additional_name;
        $this->receiver_street = $invoice->receiver_street;
        $this->receiver_house_number = $invoice->receiver_house_number;
        $this->receiver_city = $invoice->receiver_city;
        $this->receiver_postcode = $invoice->receiver_postcode;
        $this->receiver_phone = $invoice->receiver_phone;
        $this->receiver_email = $invoice->receiver_email;
    }

    /**
     * @throws Throwable
     */
    public function store(): void
    {
        // validation
        $this->validate();

        // saving Invoice
        DB::transaction(function () {
            $this->invoice = Invoice::create(
                $this->except(['invoice', 'inputs', 'travelExpenses'])
            );
        });

        $this->saveItemsAndTravelExpenses();
        $this->setTotalAmount();
    }

    public function update(): void
    {
        // validation
        $data = $this->validate();

        $this->invoice->fill($data);
        $this->invoice->save();

        $this->saveItemsAndTravelExpenses();
        $this->setTotalAmount();
    }

    #endregion

    #region: process functions
    protected function saveInvoiceItems(): void
    {
        if(!$this->inputs || $this->inputs->count() < 1){
            return;
        }

        foreach ($this->inputs as $input)
        {
            $this->invoice->invoiceItems()->updateOrCreate(['id'=> $input['id']], $input);
        }
    }

    protected function saveInvoiceTravelExpenses(): void
    {
        if(!$this->travelExpenses || $this->travelExpenses->count() < 1){
            return;
        }

        foreach ($this->travelExpenses as $travelExpense)
        {
            $this->invoice->invoiceTravelExpenses()->updateOrCreate(['id'=> $travelExpense['id']], $travelExpense);
        }
    }

    protected function saveItemsAndTravelExpenses(): void
    {
         $this->saveInvoiceItems();
         $this->saveInvoiceTravelExpenses();
    }

    protected function setTotalAmount(): void
    {
        $this->invoice->total_amount = $this->invoice->getTotalGrossAmount();
        $this->invoice->save();
    }

    #endregion
}
