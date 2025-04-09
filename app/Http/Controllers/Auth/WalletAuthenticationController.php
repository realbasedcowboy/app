<?php

namespace App\Http\Controllers\Auth;

use App\Domains\Affiliate\Models\InviterInvitee;
use App\Domains\Currency\Models\Currency;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserBalance;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

class WalletAuthenticationController extends Controller
{
    /**
     * @description Registration of a user based on wallets
     *
     * @throws Throwable
     */
    public function store(Request $request)
    {
        $address = $request->address;
        $affiliateCode = $request->affiliate;

        return DB::transaction(function () use ($address, $affiliateCode, $request) {
            // Check for existing user with a lock to prevent race conditions
            $user = User::where('email', $address)->first();

            if (! $user) {
                $user = User::create([
                    'name' => $address,
                    'email' => $address,
                    'password' => password_hash($address, PASSWORD_DEFAULT),
                    'email_verified_at' => now(),
                    'address' => $address,
                    'affiliate_code' => substr(uniqid(), 0, 12),
                ]);

                if ($affiliateCode) {
                    InviterInvitee::create([
                        'inviter_id' => User::whereAffiliateCode($affiliateCode)->first()->id,
                        'invitee_id' => $user->id,
                        'code' => $affiliateCode,
                    ]);
                }

                // Create all balances for the user
                Currency::all()->each(function (Currency $currency) use ($user) {
                    UserBalance::updateOrCreate([
                        'user_id' => $user->id,
                        'currency_id' => $currency->id,
                    ], [
                        'chain_id' => 1,
                        'balance' => 0,
                    ]);
                });

                // set default user balance
                $user->update([
                    'active_balance_id' => $user->balances()->first()->id,
                ]);

                event(new Registered($user));
            }

            Auth::login($user);

            $request->session()->regenerate();

            return to_route('dashboard');
        });
    }
}
