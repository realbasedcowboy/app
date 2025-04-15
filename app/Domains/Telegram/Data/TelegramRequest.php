<?php

namespace App\Domains\Telegram\Data;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;

class TelegramRequest extends Data
{
    public function __construct(
        #[MapInputName('update_id')]
        public string $updateId,
        #[MapInputName('message')]
        public TelegramMessageDto $message,
    ) {}
}
