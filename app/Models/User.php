<?php

namespace App\Models;

use App\Domains\Affiliate\Models\InviterInvitee;
use App\Domains\Currency\Models\Currency;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @mixin IdeHelperUser
 */
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, HasUuids, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'address',
        'affiliate_code',
        'active_balance_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'affiliates',
    ];

    // this wel fetch all people who join via hte affiliate code of the owner
    public function invitees(): HasMany
    {
        return $this->hasMany(InviterInvitee::class, 'inviter_id');
    }

    public function inviter(): HasOne
    {
        return $this->hasOne(InviterInvitee::class, 'invitee_id');
    }

    public function balances(): HasMany
    {
        return $this->hasMany(UserBalance::class);
    }

    public function activeBalance(): HasOne
    {
        return $this->hasOne(UserBalance::class, 'id', 'active_balance_id');
    }

    public function canPlaceBet(float $amount): bool
    {
        return $this->activeBalance->balance >= $amount;
    }

    public function subtractBetAmountFromBalance(float $amount): void
    {
        $this->activeBalance->update([
            'balance' => $this->activeBalance->balance - $amount,
        ]);
    }

    public function addBetWinningsToBalance(float $amount): void
    {
        $this->activeBalance->update([
            'balance' => $this->activeBalance->balance + $amount,
        ]);
    }

    public function currencies(): HasMany
    {
        return $this->hasMany(Currency::class);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
