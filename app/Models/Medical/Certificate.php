<?php

namespace App\Models\Medical;

use App\Enums\Medical\SalutationType;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Certificate extends BaseModel
{
    use SoftDeletes;

    public const string DOWNLOAD_TYPE_ZIP = 'zip';
    public const string DOWNLOAD_TYPE_EMPLOYER = 'employer';
    public const string DOWNLOAD_TYPE_EMPLOYEE = 'employee';

    protected $table = 'medical_certificates';
    public $timestamps = true;
    protected $guarded = ['id'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'issue_date'        => 'date:Y-m-d',
        'examination_date'  => 'date:Y-m-d',
        'employee_birthday'  => 'date:Y-m-d',
        'employee_salutation'        => SalutationType::class,
        'employer_comment_ids' => 'array',
        'employee_comment_ids' => 'array',
    ];


    protected static function booted(): void
    {
        static::creating(function ($certificate) {

            $prefix = 'VB-';
            $date = now()->format('ymi'); // e.g. 250401123

            // Find last number for this time bucket
            $last = self::where('certificate_number', 'like', $prefix . $date . '%')
                ->orderByDesc('certificate_number')
                ->lockForUpdate() // 🔴 important for concurrency --> the create function must be used in DB::transaction(function () {});
                ->first();

            if ($last) {
                // Extract last sequence
                $lastSequence = (int) substr($last->certificate_number, -2);
                $nextSequence = str_pad($lastSequence + 1, 2, '0', STR_PAD_LEFT);
            } else {
                $nextSequence = '01';
            }
            $certificate->certificate_number = $prefix . $date . $nextSequence;
        });
    }

    public function preventions(): Certificate|HasMany
    {
        return $this->hasMany(Prevention::class, 'certificate_id');
    }
}
