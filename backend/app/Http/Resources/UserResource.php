<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

/**
 * @mixin \App\Models\User
 */
class UserResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $isSelf = $request->user()?->id === $this->id;

        return [
            'id' => $this->id,
            'name' => $this->name,
            // Handles are derived (not stored): the local part of the email is
            // unique by definition, so it doubles as a stable @handle.
            'handle' => '@'.Str::of($this->email)->before('@')->lower(),
            'avatar_url' => $this->avatar_url,
            // Email is PII — only ever exposed to the account owner.
            'email' => $this->when($isSelf, $this->email),
            'videos_count' => $this->whenCounted('videos'),
            'followers_count' => $this->whenCounted('followers'),
            'following_count' => $this->whenCounted('followings'),
            'likes_received_count' => $this->when(isset($this->likes_received_count), $this->likes_received_count ?? 0),
            'is_followed_by_me' => $this->when(
                $request->user() && isset($this->is_followed_by_me),
                fn () => (bool) $this->is_followed_by_me
            ),
        ];
    }
}
