<?php

namespace Database\Factories;

use App\Domains\Betting\Enums\BetStatusEnum;
use App\Domains\Betting\Enums\GameTypeEnum;
use App\Domains\Betting\Models\Bet;
use App\Domains\Currency\Models\Currency;
use App\Models\User;
use App\Models\UserBalance;
use Illuminate\Database\Eloquent\Factories\Factory;

class BetFactory extends Factory
{
    protected $model = Bet::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'game_type' => GameTypeEnum::Coinflip,
            'amount' => $this->faker->randomFloat(2, 1, 100),
            'choice' => $this->faker->randomElement(['heads', 'tails']),
            'server_seed_hash' => $this->faker->sha1,
            'server_seed' => $serverSeed = $this->faker->randomFloat(2, 1, 100),
            'client_seed' => $clientSeed = $this->faker->randomFloat(2, 1, 100),
            'nonce' => $nonce = $this->faker->randomFloat(2, 1, 100),
            'result' => hash('sha256', $clientSeed.$serverSeed.$nonce),
            'status' => BetStatusEnum::Placed,
            'user_balance_id' => UserBalance::factory(),
            'currency_id' => Currency::factory(),
        ];
    }
}
