<?php

namespace App\Jobs;

use App\Domains\Currency\Models\Currency;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;

class FetchCryptoPrices implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $currencies = Currency::all()->pluck('ticker')->toArray();

        $request = Http::withHeaders([
            'X-CMC_PRO_API_KEY' => config('services.coinmarketcap.api_key'),
            'Accept' => 'application/json',
        ])
            ->get('https://pro-api.coinmarketcap.com/v2/cryptocurrency/quotes/latest', [
                'symbol' => implode(',', $currencies),
            ]);

        $response = json_decode($request->getBody()->getContents());

        foreach ($response->data as $symbol => $data) {
            foreach ($data as $item) {

                $tokenAddress = $item->platform->token_address;
                try {
                    $price = $item->quote->USD->price;
                } catch (\Exception $e) {

                }

                $currency = Currency::whereContractAddress($tokenAddress)->first();

                if ($currency) {
                    $currency->update([
                        'price' => $price,
                    ]);
                }
            }
        }
    }
}
