<?php

use Telegram\Bot\Laravel\Facades\Telegram;

Route::post('telegram/webhook', function() {
    Telegram::commandsHandler(true);
    return 'ok';
});
