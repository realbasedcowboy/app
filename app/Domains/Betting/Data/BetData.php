<?php

namespace App\Domains\Betting\Data;

use App\Domains\Betting\Enums\GameTypeEnum;

class BetData
{
    public function __construct(
        public float $amount,
        public string $choice,
        public string $client_seed,
        public GameTypeEnum|int $gameType = GameTypeEnum::Coinflip
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            amount: (float) $data['amount'],
            choice: $data['choice'],
            client_seed: $data['clientSeed'],
            gameType: $data['gameType']
        );
    }

    public function toArray(): array
    {
        return [
            'amount' => $this->amount,
            'choice' => $this->choice,
            'client_seed' => $this->client_seed,
            'gameType' => $this->gameType,
        ];
    }
}
