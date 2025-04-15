<?php

namespace App\Domains\Telegram\Data;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;

class TelegramMessageDto extends Data
{
    public function __construct(
        #[MapInputName('message_id')]
        public string $messageId,
        public string $text,
        public TelegramMessageFromDto $from,
        public TelegramMessageChatDto $chat,
    ) {}
}
