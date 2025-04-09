<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Client\ConnectionException;

class FetchCryptoPrices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-crypto-prices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetches crypto prices';

    /**
     * Execute the console command.
     *
     * @throws ConnectionException
     */
    public function handle(): void
    {
        \App\Jobs\FetchCryptoPrices::dispatch();
    }
}
