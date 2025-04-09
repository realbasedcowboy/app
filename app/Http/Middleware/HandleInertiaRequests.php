<?php

namespace App\Http\Middleware;

use App\Domains\Currency\Models\Currency;
use App\Models\User;
use App\Models\UserBalance;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        /** @var User $user */
        $user = $request->user();

        $currencies = Currency::all()->collect();

        $mappedBalances = $user ? collect($user->balances->map(function (UserBalance $balance) {
            return [
                'currency_id' => $balance->currency_id,
                'balance' => $balance->balance,
            ];
        })) : collect();

        $currenciesWithBalances = $currencies->map(function (Currency $currency) use ($mappedBalances) {
            return [
                'currency_id' => $currency->id,
                'balance' => $mappedBalances->where('currency_id', $currency->id)->first()['balance'] ?? 0,
                'ticker' => $currency->ticker,
                'deposit_address' => $currency->deposit_address,
            ];
        });

        $balances = [];
        if (auth()->check()) {
            $balances = [
                'active_balance' => $user->activeBalance,
                'active_currency' => $user->activeBalance->currency,
                'balances' => $currenciesWithBalances,
            ];
        }

        return [
            ...parent::share($request),
            'name' => config('app.name'),
            'auth' => [
                'user' => $user,
                ...$balances,
            ],
            'flash' => function () use ($request) {
                return [
                    'placedBet' => $request->session()->get('placedBet'),
                ];
            },
        ];
    }
}
