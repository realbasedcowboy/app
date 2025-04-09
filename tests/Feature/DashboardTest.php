<?php

use App\Models\User;
use Database\Seeders\CurrencySeeder;
use Database\Seeders\UserBalanceSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\seed;

uses(RefreshDatabase::class);

beforeEach(function () {
    seed([
        CurrencySeeder::class,
        UserBalanceSeeder::class,
    ]);
});

test('authenticated users can visit the dashboard', function () {
    $user = User::first();
    $this->actingAs($user);

    $response = $this->get('/dashboard');

    $response->assertStatus(200);
});
