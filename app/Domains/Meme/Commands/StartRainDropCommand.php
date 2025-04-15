<?php

namespace App\Domains\Meme\Commands;

use App\Domains\Airdrop\Models\Airdrop;
use Illuminate\Support\Str;
use Telegram\Bot\Commands\Command;

class StartRainDropCommand extends Command
{
    protected string $name = 'rain';

    protected string $pattern = '{name} {keyword}';

    protected string $description = 'Starts a rain';

    public function handle(): void
    {
        $keyword = $this->argument('keyword', Str::random(6));

        $this->replyWithMessage([
            'text' => "Type !{$keyword} to join this airdrop!"
        ]);

        //        $rainName = $this->argument('name');

        //        if (! $activeRain) {
        //            Cache::set("rain_{$rainName}", []);
        //        }

        // 1. start rain
        // 2. store all messages of users between rain timestamp_start and timestamp_end in cache (this will be delivered via the webhook)
        // 3. stop the rain
        // 4. send shit to the winners
    }
}
