<?php

namespace App\Domains\Meme\Commands;

use App\Domains\Meme\Models\Meme;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\FileUpload\InputFile;

class ReplyRandomMemeCommand extends Command
{
    protected string $name = 'random';

    protected string $description = 'Returns a random meme from our awesome meme pool';

    public function handle(): void
    {
        $randomMeme = Meme::inRandomOrder()->first();

        $this->replyWithPhoto([
            'photo' => InputFile::create($randomMeme->getFirstMediaUrl('images')),
            'caption' => $randomMeme->title.': '.$randomMeme->description,
        ]);
    }
}
