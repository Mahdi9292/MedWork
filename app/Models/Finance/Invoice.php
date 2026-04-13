<?php

namespace App\Models\Finance;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends BaseModel
{
    use SoftDeletes;

    protected $table = 'finance_invoices';
    public $timestamps = true;
    protected $guarded = ['id'];

    /** Value Added Tax → MwSt (19%) */
    protected const float DEFAULT_VAT = 0.19;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'invoice_date' => 'date:Y-m-d',
    ];

    /**
     * Get the lines for the offer.
     */
    public function invoiceServices(): HasMany
    {
        return $this->hasMany(InvoiceItem::class, 'invoice_id');
    }

    /**
     * Get the Invoice Total Net Price.
     */
    public function getTotalNetPrice(): float
    {
        $netPrice = 0;

        foreach ($this->services as $service) {
            $quantity = $service->quantity?->value ?: 1;
            $netPrice += parseNumber($service->unit_price) * $quantity;
        }
        return $netPrice;
    }

    /**
     * Get the Invoice Tax Price.
     */
    public function getTaxPrice(): float
    {
        $vat = $this->value_added_tax ?? self::DEFAULT_VAT;
        $netPrice = $this->getTotalNetPrice();
        return floor($netPrice * $vat * 100) / 100;
    }

    /**
     * Get the Invoice Total Gross Price.
     */
    public function getTotalGrossPrice(): float
    {
        return $this->getTotalNetPrice() + $this->getTaxPrice();
    }
}
