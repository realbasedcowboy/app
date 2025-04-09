<?php

namespace App\Http\Controllers\Affiliate;

use App\Domains\Affiliate\Models\InviterInvitee;
use App\Domains\Betting\Models\Bet;
use App\Domains\Currency\Models\Currency;
use App\Http\Controllers\Controller;
use App\Models\User;
use Inertia\Inertia;

class AffiliateController extends Controller
{
    public function index()
    {
        /** @var User $user */
        $user = auth()->user();

        return Inertia::render('affiliate/Index', [
            'invitees' => $user->invitees->map(function (InviterInvitee $invitee) {
                $bets = Bet::where('user_id', $invitee->invitee->id)->get();

                return [
                    ...$invitee->invitee->toArray(),
                    'bets' => $bets->count(),
                    'wagered' => Currency::all()->map(function (Currency $currency) use ($bets) {
                        return [
                            'currency' => $currency->ticker,
                            'wagered' => $bets->where('currency_id', $currency->id)->sum('amount'),
                        ];
                    })->values(),
                ];
            })->values(),
        ]);
    }

    public function show()
    {
        return Inertia::render('affiliate/Show');
    }
}
