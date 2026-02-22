<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

/**
 * Support float numbers in string and comma format.
 * if number is set to 0 in any format zero will be saved in database instead on Null.
 * Null will be saved in database when value is empty non-zero.
 * values with comma (10,20) will be parsed to 10.20 before saving.
 *
 */
class GermanNullableCalculatedFloat implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return $value;
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if(in_array(trim($value), ['0,0', '0.0', '0', 0])) {
            return 0.00;
        }

        if(!trim($value)) {
            return Null;
        }

        return parseNumber($value);
    }
}
