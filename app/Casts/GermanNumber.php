<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

/**
 * support number in both format english and german
 * Example: 10,20 or 10.20 is treated as same.
 *
 * number is always saved with dot like 10.20
 * number is automatically formated on get to 10,20
 *
 * This may cause problems if number is used in calculations after getting
 * from database. For calculations use the other type GermanCalculatedNumber
 *
 */
class GermanNumber implements CastsAttributes
{
    public function get($model, $key, $value, $attributes)
    {
        return formatNumber($value, Null);
    }

    public function set($model, $key, $value, $attributes)
    {
        return parseNumber($value);
    }
}
