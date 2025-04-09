<?php

namespace App\Domains\Affiliate\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperInviterInvitee
 */
class InviterInvitee extends Model
{
    use HasTimestamps;
    use HasUuids;

    protected $fillable = [
        'inviter_id',
        'invitee_id',
        'code',
    ];

    //    public function inviter(): BelongsTo
    //    {
    //        return $this->belongsTo(User::class, 'inviter_id');
    //    }
    //
    //    public function invitee(): BelongsTo
    //    {
    //        return $this->belongsTo(User::class, 'invitee_id');
    //    }

    public function inviter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'inviter_id');
    }

    public function invitee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'invitee_id');
    }
}
