<?php

use Telegram\Bot\Laravel\Facades\Telegram;

Route::post('telegram/webhook', function() {
    $update = Telegram::commandsHandler(true);

    \Illuminate\Support\Facades\Log::info($update);

    return 'ok';
});
