<?php

namespace App\Enums\Traits;

trait EnumToArray
{
    public static function toArray(): array
    {
        return collect(self::cases())
            ->map(fn ($case) => $case->value)
            ->toArray();
    }
}
