<?php

namespace App\Domains\Airdrop\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin IdeHelperAirdrop
 */
class Airdrop extends Model
{
    use HasUuids, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'type',
    ];

    public function participants(): HasMany
    {
        return $this->hasMany(AirdropWinner::class);
    }

    public function winners(): HasMany
    {
        return $this->participants()->where('winner', 'true');
    }
}
