<?php

it('can create data object from telegram webhook data', function () {
    $webhookData = [
        'update_id' => 231632135,
        'message' => [
            'message_id' => 35,
            'from' => [
                'id' => 5654175940,
                'is_bot' => false,
                'first_name' => 'K.',
                'username' => 'xire1337',
                'language_code' => 'nl',
            ],
            'chat' => [
                'id' => -1002569499187,
                'title' => 'BOT TEST',
                'type' => 'supergroup',
            ],
            'date' => 1744701043,
            'text' => 'test 123',
        ],
    ];

    \App\Domains\Telegram\Data\TelegramRequest::from($webhookData);

    assert(true);
});
