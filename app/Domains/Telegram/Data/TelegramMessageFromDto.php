<?php

namespace App\Domains\Telegram\Data;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;

class TelegramMessageFromDto extends Data
{
    public function __construct(
        public string $id,
        #[MapInputName('is_bot')]
        public bool|string $isBot,
        #[MapInputName('first_name')]
        public string $firstName,
        public ?string $username = null,
        public ?string $languageCode = null
    ) {}
}
