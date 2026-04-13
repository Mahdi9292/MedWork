<?php

namespace App\Enums\Finance;

use App\Interfaces\HasOptionsInterface;
use App\Traits\EnumToCollectionTrait;

enum Quantity: int implements HasOptionsInterface
{
    use EnumToCollectionTrait;

    case HA_1   = 1; // 1
    case HA_2   = 2; // 2
    case HA_3   = 3; // 3
    case HA_4   = 4; // 4
    case HA_5   = 5; // 5
    case HA_6   = 6; // 6
    case HA_7   = 7; // 7
    case HA_8   = 8; // 8
    case HA_9   = 9; // 9
    case HA_10  = 10; // 10

    public function label(): string
    {
        return match ($this) {
            Quantity::HA_1 =>     '1',
            Quantity::HA_2 =>     '2',
            Quantity::HA_3 =>     '3',
            Quantity::HA_4 =>     '4',
            Quantity::HA_5 =>     '5',
            Quantity::HA_6 =>     '6',
            Quantity::HA_7 =>     '7',
            Quantity::HA_8 =>     '8',
            Quantity::HA_9 =>     '9',
            Quantity::HA_10 =>    '10',
        };
    }
}
