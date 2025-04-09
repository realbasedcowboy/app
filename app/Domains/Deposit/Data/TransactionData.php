<?php

namespace App\Domains\Deposit\Data;

use Spatie\LaravelData\Data;

class TransactionData extends Data
{
    public function __construct(
        public string $hash,
        public string $fromAddress,
        public string $toAddress,
        public int $value,
        public bool $receiptStatus
    ) {}
}
