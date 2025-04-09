<?php

namespace App\Traits;

trait BroadcastAsEvent
{
    public function broadcastAs(): string
    {
        return 'event';
    }
}
