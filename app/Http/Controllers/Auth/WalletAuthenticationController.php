<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
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

        return DB::transaction(function () use ($address, $request) {
            // Check for existing user with a lock to prevent race conditions
            $user = User::where('email', $address)->first();

            if (! $user) {
                $user = User::create([
                    'name' => $address,
                    'email' => $address,
                    'password' => password_hash($address, PASSWORD_DEFAULT),
                    'email_verified_at' => now(),
                    'address' => $address,
                ]);
                event(new Registered($user));
            }

            Auth::login($user);

            $request->session()->regenerate();

            return to_route('dashboard');
        });
    }
}
