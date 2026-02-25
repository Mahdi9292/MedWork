<?php

namespace App\Models\Medical;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Activity extends BaseModel
{
    use SoftDeletes;

    protected $table = 'medical_activities';
    public $timestamps = true;
    protected $guarded = ['id'];

    public function preventions(): Activity|HasMany
    {
        return $this->hasMany(Prevention::class, 'activity_id');
    }

}
