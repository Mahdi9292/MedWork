<?php

namespace App\Models\Finance;

use App\Casts\GermanNumber;
use App\Enums\Finance\Quantity;
use App\Enums\Finance\QuantityType;
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
        'item_date' => 'date:Y-m-d',
        'quantity'     => Quantity::class,
        'quantity_type' => QuantityType::class,
        'unit_price' => GermanNumber::class,
    ];

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }

    public function itemType(): BelongsTo
    {
        return $this->belongsTo(InvoiceItemType::class, 'item_type_id');
    }
}
