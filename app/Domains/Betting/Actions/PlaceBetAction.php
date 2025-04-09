<?php

namespace App\Domains\Betting\Actions;

use App\Domains\Betting\Data\BetData;
use App\Domains\Betting\Enums\BetStatusEnum;
use App\Domains\Betting\Models\Bet;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Throwable;

class PlaceBetAction
{
    public function __invoke(User $user, BetData $data): Bet|bool
    {
        if (! $user->canPlaceBet($data->amount)) {
            return false;
        }

        $randomString = Str::random(128);
        $serverSeed = hash('sha256', $randomString);
        $nonce = Str::random(32);

        try {
            $placedBet = DB::transaction(function () use (
                $data, $serverSeed, $nonce, $randomString, $user,
                &$bet
            ) {

                $bet = Bet::create([
                    // Add other fields
                    ...$data->toArray(),

                    // add other fields
                    'server_seed' => $randomString,
                    'server_seed_hash' => $serverSeed,
                    'nonce' => $nonce,
                    'result' => hash('sha256', $data->client_seed.$randomString.$nonce),
                    'status' => BetStatusEnum::Placed,
                    'user_id' => $user->id,
                    'user_balance_id' => $user->active_balance_id,
                    'currency_id' => $user->activeBalance->currency_id,
                    'amount_after' => (
                        $data->amount - ($data->amount / 100 * (config('affiliate.commission') + config('affiliate.company_commission')))
                    ),
                ]);

                $user->subtractBetAmountFromBalance($bet->amount);

                return $bet;
            });

            if ($placedBet) {
                app(DistributeBetAmountAction::class)($placedBet);
            }

        } catch (Throwable $e) {
            // something horrible went wrong
            dd($e->getMessage());
        }

        return $bet;
    }
}
