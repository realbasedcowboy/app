<?php

use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('user.{wallet}', function (User $user, $wallet) {
    if (auth()->check()) {
        $user = auth()->user();

        return $user->address === $wallet;
    }

    return false;
});
