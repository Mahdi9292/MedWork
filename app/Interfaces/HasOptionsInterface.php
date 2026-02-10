<?php

namespace App\Interfaces;

use Illuminate\Support\Collection;

/**
 * Class HasOptionsInterface
 * @package App
 */
interface HasOptionsInterface
{
    public function label(): string;
    public static function options(): Collection;
}
