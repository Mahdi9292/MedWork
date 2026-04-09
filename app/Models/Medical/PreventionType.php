<?php

namespace App\Models\Medical;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class PreventionType extends BaseModel
{
    use SoftDeletes;

    protected $table = 'medical_prevention_types';
    public $timestamps = true;
    protected $guarded = ['id'];

    public function preventions(): PreventionType|HasMany
    {
        return $this->hasMany(Prevention::class, 'prevention_type_id');
    }
}
