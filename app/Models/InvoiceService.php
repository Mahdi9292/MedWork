<?php

namespace App\Models;

use App\Enums\Invoice\HourAmount;
use App\Enums\Invoice\ServiceType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoiceService extends BaseModel
{
    use SoftDeletes;

    protected $table = 'invoice_services';

    public $timestamps = true;

    protected $guarded = ['id'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'service_date' => 'date:Y-m-d',
        'service_type' => ServiceType::class,
        'quantity'     => HourAmount::class,
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
