<?php

namespace App\Models\Finance;

use App\Casts\GermanNumber;
use App\Enums\Finance\InvoiceType;
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
        'issue_date' => 'date:Y-m-d',
        'total_amount' => GermanNumber::class,
        'invoice_type' => InvoiceType::class,
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

        static::saving(function (Invoice $invoice) {
            if($invoice->invoice_type != InvoiceType::QT_OTHER){
               $invoice->invoice_type_other = null;
            }
        });
    }

    #region: relations
    public function invoiceItems(): HasMany
    {
        return $this->hasMany(InvoiceItem::class, 'invoice_id');
    }

    public function invoiceTravelExpenses(): HasMany
    {
        return $this->hasMany(InvoiceTravelExpense::class, 'invoice_id');
    }

    #endregion

    #region: functions

    /**
     * $time format is like decimal: 1,15 - 2,45 - 8,00 - 2,25
     * Parse the time to decimal
     */
    public function parseTimeToDecimal(?float $time): float
    {
        if ($time === null) {
            return 0;
        }

        $hours = floor($time);
        $minutes = round(($time - $hours) * 100);
        return $hours + ($minutes / 60);
    }

    /**
     * Get the Invoice Total Net Price.
     */
    public function getTotalNetAmount(): float
    {
        $netAmount = 0;

        foreach ($this->invoiceItems as $invoiceItem) {
            $netAmount += $invoiceItem->getNetPrice();
        }

        foreach ($this->invoiceTravelExpenses as $invoiceTravelExpense) {

            if(!$invoiceTravelExpense->distance || !$invoiceTravelExpense->price_per_km){
                continue;
            }

            $distance = parseNumber($invoiceTravelExpense->distance);
            $kmPrice = parseNumber($invoiceTravelExpense->price_per_km);
            $netAmount += $distance * $kmPrice;
        }

        return $netAmount;
    }

    public function totalNetItemAmount(): float|int
    {
        $netAmount = 0;

        foreach ($this->invoiceItems as $invoiceItem) {
            $netAmount += $invoiceItem->getNetPrice();
        }

        return $netAmount;
    }

    public function totalNetTravelExpenseAmount(): float|int
    {
        $netAmount = 0;
        foreach ($this->invoiceTravelExpenses as $invoiceTravelExpense) {

            if(!$invoiceTravelExpense->distance || !$invoiceTravelExpense->price_per_km){
                continue;
            }

            $distance = parseNumber($invoiceTravelExpense->distance);
            $kmPrice = parseNumber($invoiceTravelExpense->price_per_km);
            $netAmount += $distance * $kmPrice;
        }
        return $netAmount;
    }

    /**
     * Get the Invoice Tax Price.
     */
    public function getTaxAmount(): float
    {
        $vat = $this->value_added_tax ?? self::DEFAULT_VAT;
        $netAmount = $this->getTotalNetAmount();
        return floor($netAmount * $vat * 100) / 100;
    }

    /**
     * Get the Invoice Total Gross Price.
     */
    public function getTotalGrossAmount(): float
    {
        return $this->getTotalNetAmount() + $this->getTaxAmount();
    }

    #endregion
}
