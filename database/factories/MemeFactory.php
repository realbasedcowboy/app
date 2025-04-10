<?php

namespace Database\Factories;

use App\Domains\Meme\Models\Meme;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Domains\Meme\Models\Meme>
 */
class MemeFactory extends Factory
{
    protected $model = Meme::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
        ];
    }
}
