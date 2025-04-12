<?php

use Illuminate\Http\Request;
use Telegram\Bot\FileUpload\InputFile;
use Telegram\Bot\Laravel\Facades\Telegram;

Route::post('telegram/webhook', function(Request $request) {
    //\Illuminate\Support\Facades\Log::warning($request);

    $updates = Telegram::getWebhookUpdate();
    \Illuminate\Support\Facades\Log::warning($updates);

    $chat = $updates->getChat();

    $randomImage = \App\Domains\Meme\Models\Meme::inRandomOrder()->first()->getFirstMediaUrl('images');

    Telegram::sendPhoto([
        'chat_id' => $chat->id,
        'photo' => InputFile::create($randomImage),
        'caption' => 'Roses are withered, violets decay, all in this group, you are cursed and forever gay.'
    ]);

    return 'ok';
});
