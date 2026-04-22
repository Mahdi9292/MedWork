<?php

namespace App\Models\Finance;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoiceItemType extends BaseModel
{
    use SoftDeletes;

    protected $table = 'finance_invoice_item_types';
    public $timestamps = true;
    protected $guarded = ['id'];

    public function items(): InvoiceItemType|HasMany
    {
        return $this->hasMany(InvoiceItem::class, 'item_type_id');
    }
}
