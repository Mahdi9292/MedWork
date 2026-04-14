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

    protected static function booted(): void
    {
        static::creating(function ($invoice) {

            $date = now()->format('ymi'); // e.g. 250401123

            // Find last number for this time bucket
            $last = self::where('invoice_number', 'like', $date . '%')
                ->orderByDesc('invoice_number')
                ->lockForUpdate() // 🔴 important for concurrency --> the create function must be used in DB::transaction(function () {});
                ->first();

            if ($last) {
                // Extract last sequence
                $lastSequence = (int) substr($last->invoice_number, -2);
                $nextSequence = str_pad($lastSequence + 1, 2, '0', STR_PAD_LEFT);
            } else {
                $nextSequence = '01';
            }
            $invoice->invoice_number = $date . $nextSequence;
        });
    }

    public function invoiceItems(): HasMany
    {
        return $this->hasMany(InvoiceItem::class, 'invoice_id');
    }

    public function invoiceTravelExpenses(): HasMany
    {
        return $this->hasMany(InvoiceTravelExpense::class, 'invoice_id');
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
