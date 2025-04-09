<?php

namespace App\Console\Commands;

use App\Domains\Deposit\Events\DepositProcessed;
use Illuminate\Console\Command;

class DepositFakeEth extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:deposit {amount=10000000}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test command for Deposit fake eth and test scenarios';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        DepositProcessed::dispatch('0xAf6D46d1E55AA87772Fb1538FE4d36AAA70f4e06', 'Deposit success', []);
    }

    private function payload(int $amount = 150, string $ticker = 'ETH'): array
    {
        return [
            'confirmed' => true,
            'chainId' => '0xaa36a7',
            'streamId' => 'ae9a5d8d-2da6-4fb9-b779-71c3bbbdb719',
            'tag' => 'Simple',
            'retries' => 0,
            'block' => [
                'number' => '7826317',
                'hash' => '0x351124f769f4e23668858e707bdc54bf6d806733d333eeb0508a07fc1282cc4d',
                'timestamp' => '1741034448',
            ],
            'txs' => [
                [
                    'hash' => '0x'.str()->random(),
                    'fromAddress' => '0xAf6D46d1E55AA87772Fb1538FE4d36AAA70f4e06',
                    'toAddress' => '0x3f83cea8f4cc167d1f443113120a0c5edd9d2466',
                    'value' => $amount,
                    'receiptStatus' => 1,
                ],
            ],
            'erc20Transfers' => [],
        ];
    }
}
