<?php

namespace App\Models\Medical;

use App\Enums\Medical\SalutationType;
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
        'issue_date'        => 'date:Y-m-d',
        'examination_date'  => 'date:Y-m-d',
        'salutation'        => SalutationType::class,
    ];


    protected static function booted(): void
    {
        static::creating(function ($certificate) {

            $prefix = 'VB-';
            $date = now()->format('dmis');

            do {
                $unique = str_pad(random_int(0, 99), 2, '0', STR_PAD_LEFT);
                $number = $prefix . $date . $unique;

            } while (self::where('certificate_number', $number)->exists());

            $certificate->certificate_number = $number;
        });
    }

    public function preventions(): Certificate|HasMany
    {
        return $this->hasMany(Prevention::class, 'certificate_id');
    }
}
