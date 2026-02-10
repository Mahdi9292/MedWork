<?php

namespace App\Enums\Invoice;

use App\Interfaces\HasOptionsInterface;
use App\Traits\EnumToCollectionTrait;

enum ServiceType: string implements HasOptionsInterface
{
    use EnumToCollectionTrait;

    case ST_AMVU = 'AMVU'; // Arbeitsmedizinische Vorsorgeuntersuchung

    public function label(): string
    {
        return match ($this) {
            ServiceType::ST_AMVU => 'Arbeitsmedizinische Vorsorgeuntersuchung',
        };
    }
}
