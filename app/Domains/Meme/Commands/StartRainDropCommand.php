<?php

namespace App\Domains\Meme\Commands;

use App\Domains\Airdrop\Enums\AirdropTypeEnum;
use App\Domains\Airdrop\Jobs\DeactivateAirdropJob;
use App\Domains\Airdrop\Models\Airdrop;
use Illuminate\Support\Str;
use Telegram\Bot\Commands\Command;

class StartRainDropCommand extends Command
{
    protected string $name = 'rain';

    protected string $pattern = '{name} {keyword} {password}';

    protected string $description = 'Starts a rain';

    public function handle(): void
    {
        $password = 'abc123';

        if ($password !== $this->argument('password'))
            return;

        $keyword = $this->argument('keyword', Str::random(6));

        $airdrop = Airdrop::create([
            'name' => $this->argument('name'),
            'keyword' => $keyword,
            'type' => AirdropTypeEnum::Rain,
            'active' => true,
        ]);

        $this->replyWithMessage([
            'text' => "Type !{$keyword} to join this airdrop, you only have a couple of seconds!"
        ]);

        DeactivateAirdropJob::dispatch($airdrop)->delay(5);
    }
}
