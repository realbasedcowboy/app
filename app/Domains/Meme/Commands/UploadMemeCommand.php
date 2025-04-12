<?php

namespace App\Domains\Meme\Commands;

use App\Domains\Meme\Models\Meme;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\FileUpload\InputFile;

class UploadMemeCommand extends Command
{
    protected string $name = 'upload';
    protected string $description = 'Uploads your meme for voting';

    public function handle(): void
    {
        // $randomImage = Meme::inRandomOrder()->first()->getFirstMediaUrl('images');

//        $this->replyWithPhoto([
//            'photo' => InputFile::create($randomImage),
//            'caption' => 'Roses are withered, violets decay, all in this group, you are cursed and forever gay.'
//        ]);
    }
}
