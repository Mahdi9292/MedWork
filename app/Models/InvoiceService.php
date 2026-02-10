<?php

namespace App\Models;

use App\Enums\Invoice\ServiceType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoiceService extends Model
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
        'type' => ServiceType::class,
    ];

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }
}
