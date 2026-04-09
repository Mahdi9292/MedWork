<?php

namespace App\Models\Medical;

use App\Enums\Medical\CommentType;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends BaseModel
{
    use SoftDeletes;

    protected $table = 'medical_comments';
    public $timestamps = true;
    protected $guarded = ['id'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'type'        => CommentType::class,
    ];

    public function employerCertificates(): HasMany
    {
        return $this->hasMany(Certificate::class, 'employer_comment_id');
    }

    public function employeeCertificates(): HasMany
    {
        return $this->hasMany(Certificate::class, 'employee_comment_id');
    }

    // scopes for queries
    public function scopeEmployer($query)
    {
        return $query->where('type', 'employer');
    }

    public function scopeEmployee($query)
    {
        return $query->where('type', 'employee');
    }
}
