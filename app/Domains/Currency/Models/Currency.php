<?php

namespace App\Domains\Currency\Models;

use App\Models\Scopes\PublishedScope;
use App\Models\User;
use Database\Factories\CurrencyFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @mixin IdeHelperCurrency
 */
class Currency extends Model
{
    use HasFactory, HasUuids;

    protected static function booted(): void
    {
        self::addGlobalScope(new PublishedScope);
    }

    protected $fillable = [
        'ticker',
        'name',
        'contract_address',
        'chain_id',
        'deposit_address',
        'price',
        'published',
        'cmc_url',
    ];

    protected $casts = [
        'published' => 'boolean',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected static function newFactory(): CurrencyFactory
    {
        return CurrencyFactory::new();
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }
}
