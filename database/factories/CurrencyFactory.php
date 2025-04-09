<?php

namespace Database\Factories;

use App\Domains\Currency\Models\Currency;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Domains\Currency\Models\Currency>
 */
class CurrencyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Currency::class;

    public function definition(): array
    {
        return [
            'ticker' => $this->faker->currencyCode(),
            'name' => $this->faker->currencyCode(),
            'chain_id' => $this->faker->uuid(),
            'deposit_address' => $this->faker->address(),
            'contract_address' => $this->faker->address(),
        ];
    }
}
