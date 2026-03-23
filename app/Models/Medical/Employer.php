<?php

namespace App\Models\Medical;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employer extends BaseModel
{
    use SoftDeletes;

    protected $table = 'medical_employers';
    public $timestamps = true;
    protected $guarded = ['id'];

    public function employees(): HasMany|Employer
    {
        return $this->hasMany(Employee::class, 'employer_id');
    }

}
