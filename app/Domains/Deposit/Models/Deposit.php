<?php

namespace App\Domains\Deposit\Models;

use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperDeposit
 */
class Deposit extends Model
{
    use HasTimestamps, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'transaction_hash',
        'sender',
        'token_address',
        'token_ticker',
        'amount',
        'block',
        'block_timestamp',
        'block_hash',
        'confirmed',
        'receipt_status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'amount' => 'decimal:18',
        'block_timestamp' => 'datetime',
        'confirmed' => 'boolean',
        'receipt_status' => 'boolean',
    ];
}
