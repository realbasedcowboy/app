<?php

namespace App\Domains\Meme\Commands;

use App\Domains\Meme\Models\Meme;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\FileUpload\InputFile;

class ReplyRandomMemeCommand extends Command
{
    protected string $name = 'random';
    protected string $description = 'Returns a random meme from our pool';

    public function handle(): void
    {
        $randomImage = Meme::inRandomOrder()->first()->getFirstMediaUrl('images');

        $this->replyWithPhoto([
            'photo' => InputFile::create($randomImage),
            'caption' => 'Roses are withered, violets decay, all in this group, you are cursed and forever gay.'
        ]);
    }
}
