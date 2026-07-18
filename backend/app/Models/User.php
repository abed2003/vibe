<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar_url',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

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

    /**
     * The videos uploaded by this user.
     *
     * @return HasMany<\App\Models\Video>
     */
    public function videos(): HasMany
    {
        return $this->hasMany(Video::class);
    }

    /**
     * Comments written by this user.
     *
     * @return HasMany<\App\Models\Comment>
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Likes given by this user.
     *
     * @return HasMany<\App\Models\Like>
     */
    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    /**
     * Videos this user has bookmarked.
     *
     * @return HasMany<\App\Models\Save>
     */
    public function saves(): HasMany
    {
        return $this->hasMany(Save::class);
    }

    /**
     * Follow records pointing at this user (their followers).
     *
     * @return HasMany<\App\Models\Follow>
     */
    public function followers(): HasMany
    {
        return $this->hasMany(Follow::class, 'following_id');
    }

    /**
     * Follow records created by this user (who they follow).
     *
     * @return HasMany<\App\Models\Follow>
     */
    public function followings(): HasMany
    {
        return $this->hasMany(Follow::class, 'follower_id');
    }

    public function isFollowedBy(?User $user): bool
    {
        return $user !== null
            && $this->followers()->where('follower_id', $user->id)->exists();
    }
}
