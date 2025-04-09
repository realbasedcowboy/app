<?php

namespace App\Domains\Betting\Models;

use App\Domains\Betting\Enums\BetStatusEnum;
use App\Domains\Betting\Enums\GameTypeEnum;
use App\Models\User;
use Database\Factories\BetFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Horizon\SupervisorCommands\Balance;

/**
 * @mixin IdeHelperBet
 */
class Bet extends Model
{
    use HasFactory;
    use HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'user_id',
        'game_type',
        'amount',
        'amount_after',
        'choice',
        'server_seed_hash',
        'server_seed',
        'client_seed',
        'nonce',
        'result',
        'status',
        'user_balance_id',
        'currency_id',
        'final_result',
        'won',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'amount' => 'float', // Decimal in DB, float in PHP
        'game_type' => GameTypeEnum::class, // Enum casting (PHP 8.1+)
        'status' => BetStatusEnum::class, // Enum casting
        'created_at' => 'datetime', // Timestamp casting (optional, default behavior)
        'updated_at' => 'datetime', // Timestamp casting
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function balance(): BelongsTo
    {
        return $this->belongsTo(Balance::class);
    }

    public function isWon(): bool
    {
        return $this->won;
    }

    public function makePending(): void
    {
        $this->update([
            'status' => BetStatusEnum::Pending,
        ]);
    }

    protected static function newFactory(): BetFactory
    {
        return BetFactory::new();
    }

    public function validateSignature(): bool {}
}
