<?php

namespace App\Domains\Betting\Controllers;

use App\Domains\Betting\Actions\CalculateBetResultAction;
use App\Domains\Betting\Actions\PlaceBetAction;
use App\Domains\Betting\Data\BetData;
use App\Domains\Betting\Enums\BetStatusEnum;
use App\Domains\Betting\Enums\GameTypeEnum;
use App\Domains\Betting\Models\Bet;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CoinFlipController extends Controller
{
    public function index(Request $request): Response
    {
        return Inertia::render('coinflip/Index');
    }

    public function bet(Request $request)
    {
        $request->validate([
            'amount' => ['required', 'numeric', 'min:1'],
            'choice' => ['required', 'string', 'in:heads,tails'],
            'clientSeed' => ['required', 'string'],
        ]);

        $data = BetData::fromArray([
            ...$request->all(),
            'gameType' => GameTypeEnum::Coinflip,
        ]);

        app(PlaceBetAction::class)(
            $request->user(), $data
        );

        $bets = Bet::whereIn('status', [
            BetStatusEnum::Placed->value,
            BetStatusEnum::Pending->value,
        ])->get();

        $bets->each(function (Bet $bet) {
            $bet->makePending();

            app(CalculateBetResultAction::class)($bet);
        });

        $placedBet = Bet::whereClientSeed($request->clientSeed)->orderBy('created_at', 'desc')->first();

        if ($placedBet->isWon()) {
            // give it back to the user
            $request->user()->addBetWinningsToBalance(
                $placedBet->amount + $placedBet->amount_after
            );
        }

        return redirect()->back()->with('placedBet', $placedBet->only(['client_seed', 'amount', 'server_seed', 'nonce', 'won', 'final_result']));
    }
}
