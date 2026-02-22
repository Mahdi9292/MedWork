<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends BaseModel
{
    use SoftDeletes;

    protected $table = 'invoices';
    public $timestamps = true;
    protected $guarded = ['id'];

    /** Value Added Tax → MwSt (19%) */
    protected const float VAT = 0.19;

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
    public function services(): HasMany
    {
        return $this->hasMany(InvoiceService::class, 'invoice_id');
    }

    /**
     * Get the Invoice Total Net Price.
     */
    public function getTotalNetPrice(): float
    {
        $netPrice = 0;

        foreach ($this->services as $service) {
            $netPrice += parseNumber($service->unit_price) * $service->quantity->value;
        }
        return $netPrice;
    }

    /**
     * Get the Invoice Tax Price.
     */
    public function getTaxPrice(): float
    {
        $netPrice = $this->getTotalNetPrice();
        return $netPrice * self::VAT;
    }


    /**
     * Get the Invoice Total Gross Price.
     */
    public function getTotalGrossPrice(): float
    {
        return $this->getTotalNetPrice() + $this->getTaxPrice();
    }
}
