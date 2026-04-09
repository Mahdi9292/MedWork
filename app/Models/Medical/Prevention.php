<?php

namespace App\Models\Medical;

use App\Models\BaseModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Prevention extends BaseModel
{
    use SoftDeletes;

    protected $table = 'medical_preventions';
    public $timestamps = true;
    protected $guarded = ['id'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'next_appointment_date' => 'date:Y-m-d',
    ];

    public function certificate(): BelongsTo
    {
        return $this->belongsTo(Certificate::class, 'certificate_id');
    }

    public function activity(): BelongsTo
    {
        return $this->belongsTo(Activity::class, 'activity_id');
    }

    public function preventionType(): BelongsTo
    {
        return $this->belongsTo(PreventionType::class, 'prevention_type_id');
    }
}
