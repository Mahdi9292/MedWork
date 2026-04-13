<?php

namespace App\Models\Finance;

use App\Casts\GermanNumber;
use App\Enums\Finance\HourAmount;
use App\Enums\Finance\InvoiceItemType;
use App\Models\BaseModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoiceItem extends BaseModel
{
    use SoftDeletes;

    protected $table = 'finance_invoice_services';
    public $timestamps = true;
    protected $guarded = ['id'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'service_date' => 'date:Y-m-d',
        'service_type' => InvoiceItemType::class,
        'quantity'     => HourAmount::class,
        'unit_price' => GermanNumber::class,
    ];

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }

    protected function serviceDate(): Attribute
    {
        return Attribute::make(
            set: function ($value) {
                return $value
                    ? Carbon::createFromFormat('d.m.Y', $value)->format('Y-m-d')
                    : null;
            }
        );
    }
}
