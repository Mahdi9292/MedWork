<?php

namespace App\Enums\Finance;

use App\Interfaces\HasOptionsInterface;
use App\Traits\EnumToCollectionTrait;

enum InvoiceType: string implements HasOptionsInterface
{
    use EnumToCollectionTrait;

    case QT_PERSON = 'person'; // Person
    case QT_HOUR = 'hour'; // Stunde
    case QT_EMPLOYEE = 'employee'; // Mitarbeiter


    public function label(): string
    {
        return match ($this) {
            InvoiceType::QT_PERSON => 'Person/en',
            InvoiceType::QT_HOUR => 'Stunde/n',
            InvoiceType::QT_EMPLOYEE => 'Mitarbeiter/in',
        };
    }
}
