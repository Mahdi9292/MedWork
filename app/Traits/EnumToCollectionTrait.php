<?php

namespace App\Traits;

use Illuminate\Support\Collection;

trait EnumToCollectionTrait
{
    public static function options(): Collection
    {
        return collect(self::cases())->mapWithKeys(function ($case) {
            return [$case->value => $case->label()];
        });
    }

    public static function optionsWithKeyLabel(string $key = 'key', string $label = 'label', bool $removeEmpty = true, bool $addBlankOption = false, string $blankOptionKey = 'blank', string $blankOptionLabel = 'Blank'): Collection
    {
        $options = collect(self::cases())->map(function ($case) use ($key, $label) {
            return [
                $key => $case->value,
                $label => $case->label(),
            ];
        });

        // removing empty values
        if ($removeEmpty) {
            $options = $options->filter(function ($value) use ($key) {
                return $value[$key];
            });
        }

        if ($addBlankOption) {
            $options->add(['key' => $blankOptionKey, 'label' => $blankOptionLabel]);
        }

        return $options;
    }
}
