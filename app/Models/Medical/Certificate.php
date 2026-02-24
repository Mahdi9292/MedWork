<?php

namespace App\Models\Medical;

use App\Models\BaseModel;
use App\Models\InvoiceService;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Certificate extends BaseModel
{
    use SoftDeletes;

}
