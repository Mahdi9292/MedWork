<?php

namespace App\Enums\Finance;

use App\Interfaces\HasOptionsInterface;
use App\Traits\EnumToCollectionTrait;

enum ServiceType: string implements HasOptionsInterface
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
            ServiceType::ST_OCCUPATIONAL_MEDICAL_EXAMINATION => 'Arbeitsmedizinische Vorsorgeuntersuchung',
            ServiceType::ST_TRAVEL_COSTS => 'Fahrkosten',
            ServiceType::ST_LABOR => 'Labor',
            ServiceType::ST_CONSULTING => 'Beratung',
            ServiceType::ST_ASA_MEETING => 'ASA Sitzung',
            ServiceType::ST_BEM_MEETING => 'Begehung',
            ServiceType::ST_SITE_INSPECTION => 'BEM Gespräch',
        };
    }
}
