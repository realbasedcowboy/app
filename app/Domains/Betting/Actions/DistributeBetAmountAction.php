<?php

namespace App\Domains\Betting\Actions;

use App\Domains\Betting\Models\Bet;
use App\Models\User;

class DistributeBetAmountAction
{
    public function __invoke(Bet $bet): bool
    {
        $affiliateCommissionPercentage = config('affiliate.commission');

        if ($bet->user->inviter === null) {
            // we take the full commission
            $companyCommissionPercentage = config('affiliate.company_commission');

            $totalCommission = ($bet->amount / 100 * (
                $companyCommissionPercentage + $affiliateCommissionPercentage
            ));

            $user = User::whereEmail('app@hopiumbet.com')->first();
            $balance = $user->balances->where('currency_id', '=', $bet->currency_id)->first();

            $balance->update([
                'balance' => $balance->balance + $totalCommission,
            ]);

            return true;
        }

        $affiliateCommission = ($bet->amount / 100 * $affiliateCommissionPercentage);

        $balance = $bet->user->inviter->inviter->balances->where('currency_id', '=', $bet->currency_id)->first();

        if ($balance === null) {
            // this should never happen but in case we create a new balance
            $bet->user->inviter->inviter->balances()->create([
                'currency_id' => $bet->currency_id,
                'balance' => $affiliateCommission,
                'chain_id' => 1,
            ]);
        }

        $balance->update([
            'balance' => $balance->balance + $affiliateCommission,
        ]);

        return true;
    }
}
