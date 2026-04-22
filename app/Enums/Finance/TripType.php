<?php

namespace App\Enums\Finance;

use App\Interfaces\HasOptionsInterface;
use App\Traits\EnumToCollectionTrait;

enum TripType: string implements HasOptionsInterface
{
    use EnumToCollectionTrait;

    case TT_ROUND_TRIP = 'round_trip'; // Person
    case TT_ONE_WAY = 'one_way'; // Stunde

    public function label(): string
    {
        return match ($this) {
            TripType::TT_ROUND_TRIP => 'Hin- und Rückfahrt',
            TripType::TT_ONE_WAY => 'Hinfahrt'
        };
    }
}
