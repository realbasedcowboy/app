<?php

namespace App\Domains\Meme\Commands;

use Illuminate\Support\Facades\Log;
use Telegram\Bot\Commands\Command;

class UploadMemeCommand extends Command
{
    protected string $name = 'upload';
    protected string $description = 'Uploads your meme for voting';

    public function handle(): void
    {
        // $data = $this->getUpdate();
    }
}
