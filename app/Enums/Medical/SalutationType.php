<?php

namespace App\Enums\Medical;

use App\Interfaces\HasOptionsInterface;
use App\Traits\EnumToCollectionTrait;

enum SalutationType: string implements HasOptionsInterface
{
    use EnumToCollectionTrait;

    case ST_MR = 'Mr'; // Herr
    case ST_MS = 'Ms'; // Frau

    public function label(): string
    {
        return match ($this) {
            SalutationType::ST_MR => 'Herr',
            SalutationType::ST_MS => 'Frau',
        };
    }
}
