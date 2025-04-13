<?php

namespace App\Domains\Meme\Commands;

use App\Domains\Meme\Models\Meme;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\FileUpload\InputFile;
use Telegram\Bot\Keyboard\Keyboard;

class ReplyRandomMemeCommand extends Command
{
    protected string $name = 'random';
    protected string $description = 'Returns a random meme from our awesome meme pool';

    public function handle(): void
    {
        $randomMeme = Meme::inRandomOrder()->first();

//        $keyboard = Keyboard::make()->inline()->row([
//            Keyboard::inlineButton(['text' => '👍 Like', 'callback_data' => "like_{$randomMeme->id}"]),
//            Keyboard::inlineButton(['text' => '👎 Dislike', 'callback_data' => "dislike_{$randomMeme->id}"]),
//        ]);

        $this->replyWithPhoto([
            'photo' => InputFile::create($randomMeme->getFirstMediaUrl('images')),
            'caption' => $randomMeme->title.': '.$randomMeme->description,
//            'reply_markup' => $keyboard,
        ]);
    }
}
