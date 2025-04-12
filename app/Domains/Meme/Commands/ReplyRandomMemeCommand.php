<?php

namespace App\Domains\Meme\Commands;

use App\Domains\Meme\Models\Meme;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\FileUpload\InputFile;
use Telegram\Bot\Laravel\Facades\Telegram;

class ReplyRandomMemeCommand extends Command
{
    protected string $name = 'random';
    protected string $description = 'Returns a random meme from our pool';

    /**
     * @throws TelegramSDKException
     */
    public function handle()
    {
        $updates = $this->getUpdate();

        $chat = $updates->getChat();

        $randomImage = Meme::inRandomOrder()->first()->getFirstMediaUrl('images');

        Telegram::sendPhoto([
            'chat_id' => $chat->id,
            'photo' => InputFile::create($randomImage),
            'caption' => 'Roses are withered, violets decay, all in this group, you are cursed and forever gay.'
        ]);
    }
}
