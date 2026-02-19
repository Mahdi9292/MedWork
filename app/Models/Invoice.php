<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends BaseModel
{
    use SoftDeletes;

    protected $table = 'invoices';
    public $timestamps = true;
    protected $guarded = ['id'];

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
}
