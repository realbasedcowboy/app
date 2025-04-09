<?php

namespace Database\Seeders;

use App\Domains\Currency\Models\Currency;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        collect([
            [
                // BSC CHAIN
                'ticker' => 'CHMB',
                'name' => 'Chumbi Valley',
                'contract_address' => '0x5492Ef6aEebA1A3896357359eF039a8B11621b45',
                'chain_id' => 56,
                'deposit_address' => '',
                'price' => 0,
                'cmc_url' => '',
                'published' => true,
            ],
            // BSC CHAIN
            [
                'ticker' => 'TLM',
                'name' => 'Alien Worlds Trilium',
                'contract_address' => '0x2222227e22102fe3322098e4cbfe18cfebd57c95',
                'chain_id' => 56,
                'deposit_address' => '',
                'price' => 0,
                'cmc_url' => '',
                'published' => true,
            ],
            // SOLANA
            [
                'ticker' => 'ATLAS',
                'name' => 'Star Atlas',
                'contract_address' => 'ATLASXmbPQxBUYbxPsV97usA3fPQYEqzQBUHgiFCUsXx',
                'chain_id' => 101,
                'deposit_address' => '',
                'price' => 0,
                'cmc_url' => '',
                'published' => true,
            ],
        ])->each(function ($currency) {
            Currency::factory()->create($currency);
        });
    }
}
