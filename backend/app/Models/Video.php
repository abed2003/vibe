<?php

namespace App\Models;

use App\Enums\VideoStatus;
use App\Enums\VideoVisibility;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Video extends Model
{
    /** @use HasFactory<\Database\Factories\VideoFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'visibility',
    ];

    /**
     * Fields written only by the upload/processing pipeline, never by mass
     * assignment from a request. Kept out of $fillable deliberately.
     */
    protected $guarded = [
        'id',
        'uuid',
        'user_id',
        'disk',
        'path',
        'thumbnail_path',
        'original_filename',
        'mime_type',
        'size_bytes',
        'duration_seconds',
        'width',
        'height',
        'status',
        'views_count',
        'failure_reason',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'status' => VideoStatus::class,
            'visibility' => VideoVisibility::class,
            'size_bytes' => 'integer',
            'duration_seconds' => 'integer',
            'width' => 'integer',
            'height' => 'integer',
            'views_count' => 'integer',
            'published_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Video $video) {
            $video->uuid ??= (string) Str::ulid();
        });
    }

    /**
     * Route/API models are looked up by the public ULID, never the internal
     * auto-increment id, so ids can't be enumerated by iterating URLs.
     */
    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopePubliclyVisible(Builder $query): Builder
    {
        return $query->where('visibility', VideoVisibility::Public)
            ->where('status', VideoStatus::Ready);
    }

    public function scopeOwnedBy(Builder $query, User $user): Builder
    {
        return $query->where('user_id', $user->id);
    }

    public function isOwnedBy(?User $user): bool
    {
        return $user !== null && $user->id === $this->user_id;
    }
}
