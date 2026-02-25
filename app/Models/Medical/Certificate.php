<?php

namespace App\Models\Medical;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Certificate extends BaseModel
{
    use SoftDeletes;

    protected $table = 'medical_certificates';
    public $timestamps = true;
    protected $guarded = ['id'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'issue_date' => 'date:Y-m-d',
    ];

    public function preventions(): Certificate|HasMany
    {
        return $this->hasMany(Prevention::class, 'certificate_id');
    }
}
