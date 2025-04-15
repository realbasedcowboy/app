<?php

namespace App\Domains\Telegram\Data;

use Spatie\LaravelData\Data;

class TelegramMessageChatDto extends Data
{
    public function __construct(
        public string $id,
        public string $title,
        public string $type,
    ) {}
}
