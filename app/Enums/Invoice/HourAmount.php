<?php

namespace App\Enums\Invoice;

use App\Interfaces\HasOptionsInterface;
use App\Traits\EnumToCollectionTrait;

enum HourAmount: int implements HasOptionsInterface
{
    use EnumToCollectionTrait;

    case HA_1   = 1; // 1 Hour
    case HA_2   = 2; // 2 Hour
    case HA_3   = 3; // 3 Hour
    case HA_4   = 4; // 4 Hour
    case HA_5   = 5; // 5 Hour
    case HA_6   = 6; // 6 Hour
    case HA_7   = 7; // 7 Hour
    case HA_8   = 8; // 8 Hour
    case HA_9   = 9; // 9 Hour
    case HA_10  = 10; // 10 Hour

    public function label(): string
    {
        return match ($this) {
            HourAmount::HA_1 =>     '1 Stunde',
            HourAmount::HA_2 =>     '2 Stunde',
            HourAmount::HA_3 =>     '3 Stunde',
            HourAmount::HA_4 =>     '4 Stunde',
            HourAmount::HA_5 =>     '5 Stunde',
            HourAmount::HA_6 =>     '6 Stunde',
            HourAmount::HA_7 =>     '7 Stunde',
            HourAmount::HA_8 =>     '8 Stunde',
            HourAmount::HA_9 =>     '9 Stunde',
            HourAmount::HA_10 =>    '10 Stunde',
        };
    }
}
