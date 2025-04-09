<?php

namespace Database\Seeders;

use App\Domains\Currency\Models\Currency;
use App\Models\User;
use App\Models\UserBalance;
use Illuminate\Database\Seeder;

class UserBalanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'email' => 'app@hopiumbet.com',
        ]);

        Currency::all()->each(function (Currency $currency) use ($user) {
            UserBalance::updateOrCreate([
                'user_id' => $user->id,
                'currency_id' => $currency->id,
            ], [
                'chain_id' => 1,
                'balance' => 0,
            ]);
        });

        $user->update([
            'active_balance_id' => UserBalance::first()->id,
        ]);
    }
}
