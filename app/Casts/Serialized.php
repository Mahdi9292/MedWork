<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class Serialized implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes)
    {
        return $value ? unserialize($value) : null;
    }

    public function set($model, string $key, $value, array $attributes)
    {
        return serialize($value);
    }
}
