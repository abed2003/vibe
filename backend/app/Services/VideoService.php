<?php

namespace App\Services;

use App\Enums\VideoStatus;
use App\Enums\VideoVisibility;
use App\Events\VideoUploaded;
use App\Events\VideoViewed;
use App\Models\User;
use App\Models\Video;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

/**
 * Orchestrates the write-side lifecycle of a Video: accepting an upload,
 * recording a (deduped) view, and deleting. Read-side query logic (feed,
 * profile listing) lives directly on the Video model as scopes, since it
 * doesn't need any orchestration beyond the query itself.
 */
class VideoService
{
    /**
     * Store the uploaded file and create the Video row (status: Pending).
     * Fires VideoUploaded, which a listener turns into a queued processing job.
     */
    public function upload(User $user, UploadedFile $file, array $attributes = []): Video
    {
        $disk = config('videos.disk');

        // Generated here (not left to Video::booted()'s creating() fallback) so the
        // storage path can deterministically embed the same identifier as the
        // video's public uuid.
        $uuid = (string) Str::ulid();
        $extension = $file->getClientOriginalExtension() ?: $file->extension() ?: 'mp4';
        $path = $file->storeAs('videos', "{$uuid}.{$extension}", $disk);

        // Video's $guarded list intentionally blocks mass assignment of every
        // pipeline-owned column from a request; forceCreate() is the deliberate,
        // narrow bypass for this trusted, internal write path.
        $video = Video::forceCreate([
            'uuid' => $uuid,
            'user_id' => $user->id,
            'title' => $attributes['title'] ?? null,
            'description' => $attributes['description'] ?? null,
            'visibility' => $attributes['visibility'] ?? VideoVisibility::Public,
            'disk' => $disk,
            'path' => $path,
            'original_filename' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'size_bytes' => $file->getSize(),
            'status' => VideoStatus::Pending,
        ]);

        event(new VideoUploaded($video));

        return $video;
    }

    /**
     * Record a view, deduped per (video, viewer) within a TTL window so page
     * refreshes / repeated requests from the same viewer don't inflate the
     * counter. The actual counter increment happens asynchronously off the
     * VideoViewed event, keeping this call cheap on the request's hot path.
     */
    public function recordView(Video $video, ?User $viewer, string $viewerFingerprint): void
    {
        $key = "videos:{$video->uuid}:viewed:{$viewerFingerprint}";
        $ttl = now()->addMinutes(config('videos.view_dedupe_ttl_minutes'));

        // Cache::add() is an atomic "set only if absent" — concurrent requests from
        // the same viewer can't both win the race and both fire the event.
        if (Cache::add($key, true, $ttl)) {
            event(new VideoViewed($video->id, $viewer?->id, $viewerFingerprint));
        }
    }

    /**
     * Soft-delete a video. The underlying file is deliberately left in place:
     * physical purge is handled by a separate, later retention process (see
     * Optimization Notes) so a delete request stays fast and reversible
     * during the moderation/undo window.
     */
    public function delete(Video $video): void
    {
        $video->delete();
    }
}
