<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

/**
 * @mixin \App\Models\Comment
 */
class CommentResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'body' => $this->body,
            'created_at' => $this->created_at->toIso8601String(),
            'mine' => $request->user()?->id === $this->user_id,
            // Only present when the caller eager-loaded `user` (see VideoResource).
            'author' => $this->whenLoaded('user', fn () => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'handle' => '@'.Str::of($this->user->email)->before('@')->lower(),
                'avatar_url' => $this->user->avatar_url,
            ]),
        ];
    }
}
