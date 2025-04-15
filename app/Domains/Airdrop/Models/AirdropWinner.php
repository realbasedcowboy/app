<?php

namespace App\Domains\Airdrop\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AirdropWinner extends Model {

    protected $table = 'airdrop_winners';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
