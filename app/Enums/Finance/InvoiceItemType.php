<?php

namespace App\Enums\Finance;

use App\Interfaces\HasOptionsInterface;
use App\Traits\EnumToCollectionTrait;

enum InvoiceItemType: string implements HasOptionsInterface
{
    use EnumToCollectionTrait;

    case ST_OCCUPATIONAL_MEDICAL_EXAMINATION = 'occupational_medical_examination'; // Arbeitsmedizinische Vorsorgeuntersuchung
    case ST_TRAVEL_COSTS = 'travel_costs'; // Fahrkosten
    case ST_LABOR = 'labor'; // Labor
    case ST_CONSULTING = 'consulting'; // Beratung
    case ST_ASA_MEETING = 'asa_meeting'; // ASA Sitzung
    case ST_BEM_MEETING = 'bem_meeting'; // Begehung
    case ST_SITE_INSPECTION = 'site_inspection'; // BEM Gespräch

    public function label(): string
    {
        return match ($this) {
            InvoiceItemType::ST_OCCUPATIONAL_MEDICAL_EXAMINATION => 'Arbeitsmedizinische Vorsorgeuntersuchung',
            InvoiceItemType::ST_TRAVEL_COSTS => 'Fahrkosten',
            InvoiceItemType::ST_LABOR => 'Labor',
            InvoiceItemType::ST_CONSULTING => 'Beratung',
            InvoiceItemType::ST_ASA_MEETING => 'ASA Sitzung',
            InvoiceItemType::ST_BEM_MEETING => 'Begehung',
            InvoiceItemType::ST_SITE_INSPECTION => 'BEM Gespräch',
        };
    }
}
