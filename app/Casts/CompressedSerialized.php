<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class CompressedSerialized implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes)
    {
        if ($value === null || $value === '') {
            return null;
        }

        $decoded = base64_decode($value, true);
        if ($decoded === false) {
            return null;
        }

        $uncompressed = @gzuncompress($decoded);
        if ($uncompressed === false) {
            return null;
        }

        // Allow all classes (Carbon, your domain objects, etc.)
        $result = @unserialize($uncompressed, ['allowed_classes' => true]);

        // Handle the special case where the serialized value is boolean false ("b:0;")
        return ($result === false && $uncompressed !== 'b:0;') ? null : $result;
    }

    public function set($model, string $key, $value, array $attributes)
    {
        if ($value === null) {
            return [$key => null];
        }

        $serialized = serialize($value);
        $compressed = gzcompress($serialized, 9);
        if ($compressed === false) {
            // Fallback: store uncompressed if compression fails (rare)
            return [$key => base64_encode($serialized)];
        }

        return [$key => base64_encode($compressed)];
    }
}
