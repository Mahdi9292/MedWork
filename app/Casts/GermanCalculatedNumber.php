<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

/**
 * support number in both format english and german
 * Example: 10,20 or 10.20 is treated as same on saving.
 *
 * number is always saved with dot like 10.20
 * number will not be automatically formated on get to 10,20. has to be
 * converted manually.
 *
 * if number is not getting used in the calculations before display
 * use GermanNumber cast class, which will convert it automatically on display.
 *
 */
class GermanCalculatedNumber implements CastsAttributes
{
    public function get($model, $key, $value, $attributes)
    {
        return $value;
    }

    public function set($model, $key, $value, $attributes)
    {
        return parseNumber($value, false);
    }
}
