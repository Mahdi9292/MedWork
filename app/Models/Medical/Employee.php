<?php

namespace App\Models\Medical;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends BaseModel
{
    use SoftDeletes;

    protected $table = 'medical_employees';
    public $timestamps = true;
    protected $guarded = ['id'];

    public function employer(): BelongsTo
    {
        return $this->belongsTo(Employer::class, 'employer_id');
    }

    public function certificates(): HasMany|Employee
    {
        return $this->hasMany(Certificate::class, 'employee_id');
    }

}
