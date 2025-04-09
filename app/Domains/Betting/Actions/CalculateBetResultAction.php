<?php

namespace App\Domains\Betting\Actions;

use App\Domains\Betting\Enums\BetStatusEnum;
use App\Domains\Betting\Models\Bet;
use Illuminate\Support\Arr;

class CalculateBetResultAction
{
    public function __invoke(Bet $bet): bool
    {
        $result = hash('sha256', $bet->client_seed.$bet->server_seed.$bet->nonce);

        if ($result !== $bet->result) {
            $bet->update([
                'status' => BetStatusEnum::Finished,
                'final_result' => 'invalid',
                'won' => false,
            ]);

            return false;
        }

        preg_match_all('/[0-9]/', $bet->result, $matches);

        $matches = collect(Arr::first($matches));

        $choice = ($matches->sum() % 2 === 0) ? 'heads' : 'tails';

        $bet->update([
            'status' => BetStatusEnum::Finished,
            'final_result' => $choice,
            'won' => $choice === $bet->choice,
        ]);

        return $choice === $bet->choice;
    }
}
