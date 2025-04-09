<?php

namespace App\Domains\Deposit\Data;

use Spatie\LaravelData\Data;

class BlockData extends Data
{
    public function __construct(
        public float $number,
        public string $hash,
        public int $timestamp,
    ) {}
}
