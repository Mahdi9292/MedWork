<?php

namespace App\Models\Medical;

use App\Casts\GermanNumber;
use App\Enums\Invoice\HourAmount;
use App\Enums\Invoice\ServiceType;
use App\Models\BaseModel;
use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Prevention extends BaseModel
{
    use SoftDeletes;

}
