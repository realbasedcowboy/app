<?php

namespace App\Domains\Meme\Models;

use Database\Factories\MemeFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin IdeHelperMeme
 */
class Meme extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'image',
    ];

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    protected static function newFactory(): MemeFactory
    {
        return MemeFactory::new();
    }
}
