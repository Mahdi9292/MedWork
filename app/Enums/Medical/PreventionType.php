<?php

namespace App\Enums\Medical;

use App\Interfaces\HasOptionsInterface;
use App\Traits\EnumToCollectionTrait;

enum PreventionType: string implements HasOptionsInterface
{
    use EnumToCollectionTrait;

    case PT_PFV = 'Pflichtvorsorge'; // Pflichtvorsorge
    case PT_ANV = 'Angebotsvorsorge'; // Angebotsvorsorge
    case PT_WUV = 'Wunschvorsorge'; // Wunschvorsorge
    case PT_EIG = 'Eignung'; // Eignung

    public function label(): string
    {
        return match ($this) {
            PreventionType::PT_PFV => 'Pflichtvorsorge',
            PreventionType::PT_ANV => 'Angebotsvorsorge',
            PreventionType::PT_WUV => 'Wunschvorsorge',
            PreventionType::PT_EIG => 'Eignung',
        };
    }
}
