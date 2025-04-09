<?php

namespace App\Domains\Deposit\Data;

use Spatie\LaravelData\Data;

class PaymentData extends Data
{
    /**
     * @param  TransactionData[]  $txs
     */
    public function __construct(
        public bool $confirmed,
        public string $chainId,
        public string $streamId,
        public BlockData $block,
        public array $txs
    ) {}
}
