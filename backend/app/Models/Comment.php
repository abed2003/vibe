<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Comment extends Model
{
    protected $fillable = [
        'video_id',
        'user_id',
        'body',
    ];

    protected static function booted(): void
    {
        static::creating(function (Comment $comment) {
            $comment->uuid ??= (string) Str::ulid();
        });
    }

    /**
     * Looked up by the public ULID, matching Video::getRouteKeyName().
     */
    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    public function video(): BelongsTo
    {
        return $this->belongsTo(Video::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isOwnedBy(?User $user): bool
    {
        return $user !== null && $user->id === $this->user_id;
    }
}
