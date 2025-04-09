<?php

namespace App\Domains\Betting\Enums;

enum BetStatusEnum: int
{
    case Placed = 1;

    case Pending = 2;

    case Finished = 3;

    case Cancelled = 4;
}
