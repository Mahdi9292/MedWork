<?php

namespace App\Enums\Medical;

use App\Interfaces\HasOptionsInterface;
use App\Traits\EnumToCollectionTrait;

enum CommentType: string implements HasOptionsInterface
{
    use EnumToCollectionTrait;

    case COMMENT_EMPLOYER = 'employer'; // Arbeitgeber
    case COMMENT_EMPLOYEE = 'employee'; // Arbeitnehmer

    public function label(): string
    {
        return match ($this) {
            CommentType::COMMENT_EMPLOYER => 'Arbeitgeber',
            CommentType::COMMENT_EMPLOYEE => 'Arbeitnehmer',
        };
    }
}
