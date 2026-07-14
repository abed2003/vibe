<?php

namespace App\Http\Resources;

use App\Enums\VideoStatus;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

/**
 * @mixin \App\Models\Video
 */
class VideoResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $isReady = $this->status === VideoStatus::Ready;

        return [
            // The internal auto-increment id is never exposed — uuid is the only
            // public identifier, matching Video::getRouteKeyName().
            'uuid' => $this->uuid,
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status->value,
            'visibility' => $this->visibility->value,
            'url' => $isReady ? Storage::disk($this->disk)->url($this->path) : null,
            'thumbnail_url' => $isReady && $this->thumbnail_path
                ? Storage::disk($this->disk)->url($this->thumbnail_path)
                : null,
            'duration_seconds' => $this->duration_seconds,
            'width' => $this->width,
            'height' => $this->height,
            'views_count' => $this->views_count,
            'published_at' => $this->published_at?->toIso8601String(),
            'created_at' => $this->created_at->toIso8601String(),
            // Only present when the caller eager-loaded `user`; omitted (not
            // lazy-loaded) otherwise, so this resource can never cause an N+1.
            'owner' => $this->whenLoaded('user', fn () => [
                'id' => $this->user->id,
                'name' => $this->user->name,
            ]),
        ];
    }
}
