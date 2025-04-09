<?php

namespace App\Models;

use App\Domains\Currency\Models\Currency;
use Database\Factories\UserBalanceFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperUserBalance
 */
class UserBalance extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'currency_id',
        'balance',
        'chain_id',
    ];

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    public static function newFactory(): UserBalanceFactory
    {
        return UserBalanceFactory::new();
    }
}
