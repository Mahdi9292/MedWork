<?php

namespace App\Enums\Finance;

use App\Interfaces\HasOptionsInterface;
use App\Traits\EnumToCollectionTrait;

enum QuantityType: string implements HasOptionsInterface
{
    use EnumToCollectionTrait;

    case QT_PERSON = 'person'; // Person
    case QT_HOUR = 'hour'; // Stunde


    public function label(): string
    {
        return match ($this) {
            QuantityType::QT_PERSON => 'Person/en',
            QuantityType::QT_HOUR => 'Stunde/n',
        };
    }
}
