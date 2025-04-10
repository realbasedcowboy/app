<?php

namespace App\Domains\Meme\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperLike
 */
class Like extends Model
{
    use HasUuids;

    protected $fillable = [
        'user_id',
        'meme_id',
        'is_liked',
    ];
}
