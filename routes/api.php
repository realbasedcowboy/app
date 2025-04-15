<?php

use App\Domains\Telegram\Data\TelegramRequest;
use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;

Route::post('telegram/webhook', function (Request $request) {
    Telegram::commandsHandler(true);

    $message = TelegramRequest::from(
        $request->toArray()
    );

    // Check if a specific word is in the text
    if (str_contains($message->message->text, 'fuck you')) {
        Telegram::sendMessage([
            'chat_id' => $message->message->chat->id,
            'text' => 'Did you just say f*ck?'
        ]);
    }

    return 'ok';
});
