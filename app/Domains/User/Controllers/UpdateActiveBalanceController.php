<?php

namespace App\Domains\User\Controllers;

use App\Http\Controllers\Controller;
use App\Models\UserBalance;
use Illuminate\Http\Request;

class UpdateActiveBalanceController extends Controller
{
    public function __invoke(Request $request)
    {
        // also check if this is the users balance
        $currencyId = $request->collect('balance.currency_id')->first();

        $request->validate([
            'currency_id' => 'exists:currencies,id',
        ]);

        $userBalance = $request->user()->balances()->where('currency_id', '=', $currencyId);

        try {
            if (
                ! $userBalance->exists()
            ) {
                /** @var UserBalance $balance */
                $balance = UserBalance::create([
                    'balance' => 0,
                    'chain_id' => 1,
                    'user_id' => $request->user()->id,
                    'currency_id' => $currencyId,
                ]);
            } else {
                $balance = $userBalance->first();
            }

            $request->user()->update([
                'active_balance_id' => $balance->id,
            ]);

        } catch (\Exception $e) {

        }
    }
}
