<?php

namespace App\Livewire\Invoice\Forms;

use App\Models\OrderBook\Order;
use App\Rules\Currency;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Livewire\Attributes\Validate;
use Livewire\Form;

class InvoiceManageForm extends Form
{
    public ?Order $order = null;
    private const string REQUIRED_MESSAGE = 'Dieses Feld muss ausgefüllt werden.';
    private const string MAX_STRING_255_MESSAGE = 'Dieses Feld darf maximal 255 Zeichen haben.';
    private const string MAX_STRING_191_MESSAGE = 'Dieses Feld darf maximal 191 Zeichen haben.';
    private const string NUMERIC_MESSAGE = 'Dieses Feld muss eine ganze Zahl sein.';

    #[Validate]
    public $status_id;

    #[Validate]
    public $slip_number;

    #[Validate]
    public ?Collection $inputs;


    #region: Order Props

    #[Validate('nullable')]
    #[Validate('max:191', message: self::MAX_STRING_191_MESSAGE)]
    public $orisa_number;

    #[Validate('required', message: self::REQUIRED_MESSAGE)]
    #[Validate('max:191', message: self::MAX_STRING_191_MESSAGE)]
    public $version;

    #

    #[Validate('nullable')]
    #[Validate([new Currency])]
    public $total_discount;

    #endregion

    protected function rules(): array
    {
        return [
            // Invoice Service
            'inputs.*.brand'                    => 'required|max:191',
            'inputs.*.device_type'              => 'nullable',
            'inputs.*.model'                    => 'required|max:191',
            'inputs.*.serial_number'            => 'nullable|max:191',
            'inputs.*.lift_cap'                 => 'nullable',
            'inputs.*.device_weight'            => 'nullable',
            'inputs.*.mast'                     => 'nullable',
            'inputs.*.lift_high'                => 'nullable',
        ];
    }

    protected array $messages = [
        'inputs.*.model.required'                       => self::REQUIRED_MESSAGE,
        'inputs.*.operating_condition_id'               => self::REQUIRED_MESSAGE,
        'inputs.*.premium_rental_plus_id'               => self::REQUIRED_MESSAGE,
        'inputs.*.prices.*.price'                       => self::REQUIRED_MESSAGE,
        'inputs.*.prices.*.type'                        => self::REQUIRED_MESSAGE,
        'inputs.*.prices.*.rental_period'               => self::REQUIRED_MESSAGE,
    ];

    public function setOrder(Order $order) :void
    {
        $invoiceServices = collect($this->invoice->services->toArray());

        $invoiceServices = $invoiceServices->map(function($invoiceService) {
            $invoiceService['unit_price'] = formatNumber(($invoiceService['unit_price'] ?? null), Null);
            return $invoiceService;
        });

        $this->fill(['inputs' => $invoiceServices]);



        //set order
        $this->slip_number = $order->slip_number;
        $this->status_id = $order->status_id;
        $this->responsible_id = $order->responsible_id;
        $this->ae_orisa = $order->ae_orisa ?? $this->ae_orisa;

    }

    public function store(): bool
    {
        $this->validate();

        $this->order = $this->order->make($this->except(['order']));

        // setting order status
        $this->order->status_id = Order::STATUS_NEW;

        // generating slip number
        $this->order->slip_number = $this->generateSlipNumber();

        if(!$this->order->slip_number){
            $this->addError('slip_number', __('orderBook.error_invalid_slip_number'));
            return false;
        }

        $this->order->save();

        if($this->inputs->count() > 0)
        {
            foreach ($this->inputs as $input)
            {
                $this->offer->lines()->updateOrCreate(['id'=> $input['id']], $input);
            }
        }

        return true;
    }

    public function update(): bool
    {
        $data = $this->validate();

        $this->order->fill($data);
        $this->order->save();

        if($this->inputs->count() > 0)
        {
            foreach ($this->inputs as $input)
            {
                $this->offer->lines()->updateOrCreate(['id'=> $input['id']], $input);
            }
        }

        return true;
    }

    /**
     * Generate slip Number for new orders
     */
    public function generateSlipNumber()
    {
        if (!isset($this->slip_number))
        {
            $dateFormat = Carbon::now()->format('Ym');
            $maxValue = Order::where('slip_number', 'like', $dateFormat.'%')->max('slip_number');
            return !$maxValue ? $dateFormat  . '0001' : intval($maxValue)  + 1;
        } elseif (preg_match('^[0-9]{4}-[0-9]{5}-[0-9]{3}-[0-9]{2}^', $this->slip_number) AND strlen($this->slip_number) === 17) {
            return $this->slip_number;
        } else {
            return false;
        }
    }

}
