<?php

namespace App\Models\Finance;

use App\Casts\GermanNumber;
use App\Enums\Finance\Quantity;
use App\Enums\Finance\QuantityType;
use App\Enums\Finance\TripType;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoiceTravelExpense extends BaseModel
{
    use SoftDeletes;

    protected $table = 'finance_invoice_travel_expenses';
    public $timestamps = true;
    protected $guarded = ['id'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'travel_date'   => 'date:Y-m-d',
        'trip_type'     => TripType::class,
        'distance'      => GermanNumber::class,
        'price_per_km'  => GermanNumber::class,
    ];

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }
}
