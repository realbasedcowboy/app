<?php

namespace App\Domains\Airdrop\Enums;

use App\Enums\Traits\EnumToArray;

enum AirdropTypeEnum: string {

    use EnumToArray;

    case Wheel = 'wheel';
    case Rain = 'rain';
}
