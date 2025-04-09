<?php

namespace App\Domains\Deposit\Actions;

use App\Domains\Currency\Models\Currency;
use App\Domains\Deposit\Events\DepositProcessed;
use App\Domains\Deposit\Models\Deposit;
use App\Models\User;
use App\Models\UserBalance;

class ProcessDepositAction
{
    public function __invoke(Deposit $deposit): void
    {
        $currency = Currency::whereTicker($deposit->token_ticker ?? 'ETH')->firstOrFail();

        $user = User::whereAddress($deposit->sender)->firstOrFail();

        $balance = $user->balances->where('currency_id', '=', $currency->id)->first();

        if (! $balance) {
            $balance = UserBalance::create([
                'user_id' => $user->id,
                'currency_id' => $currency->id,
                'balance' => 0,
                'chain_id' => 1,
                'token_ticker' => 'ETH',
            ]);
        }

        $totalBalance = $balance->balance + $deposit->amount;

        $balance->update([
            'balance' => $totalBalance,
        ]);

        DepositProcessed::dispatch(
            $deposit->sender,
            'Deposit successful',
            [
                'id' => $deposit->id,
                'transaction_hash' => $deposit->transaction_hash,
                'amount' => $deposit->amount,
                'token_ticker' => $deposit->token_ticker,
                'block_timestamp' => $deposit->block_timestamp,
                'confirmed' => $deposit->confirmed,
                'receipt_status' => $deposit->receipt_status,
            ]
        );
    }
}
