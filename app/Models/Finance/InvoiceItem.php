<?php

namespace App\Models\Finance;

use App\Casts\GermanNumber;
use App\Casts\IntegerNullable;
use App\Enums\Finance\InvoiceType;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoiceItem extends BaseModel
{
    use SoftDeletes;

    protected $table = 'finance_invoice_items';
    public $timestamps = true;
    protected $guarded = ['id'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'item_date'     => 'date:Y-m-d',
        'item_type_id'  => IntegerNullable::class,
        'quantity'      => IntegerNullable::class,
        'amount'        => GermanNumber::class,
        'unit_price'    => GermanNumber::class,
    ];

    protected static function booted(){
        static::saving(function (InvoiceItem $invoiceItem) {
            if($invoiceItem->invoice?->invoice_type == InvoiceType::QT_PERSON){
                $invoiceItem->amount = null;
                $invoiceItem->employee_name = null;
            }
            if($invoiceItem->invoice?->invoice_type == InvoiceType::QT_EMPLOYEE){
                $invoiceItem->amount = null;
                $invoiceItem->quantity = null;
            }
            if($invoiceItem->invoice?->invoice_type == InvoiceType::QT_HOUR || $invoiceItem->invoice?->invoice_type == InvoiceType::QT_OTHER){
                $invoiceItem->quantity = null;
                $invoiceItem->employee_name = null;
            }
        });
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }

    public function itemType(): BelongsTo
    {
        return $this->belongsTo(InvoiceItemType::class, 'item_type_id');
    }
}
