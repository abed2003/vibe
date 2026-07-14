<?php

namespace App\Listeners;

use App\Events\VideoProcessingFailed;
use Illuminate\Support\Facades\Log;

/**
 * Not queued: this is a cheap, local I/O write with no network call, and
 * queuing it would introduce a worse failure mode than the few extra
 * milliseconds it would save — a failure log getting lost if the queue
 * itself is unhealthy.
 */
class LogVideoProcessingFailure
{
    public function handle(VideoProcessingFailed $event): void
    {
        Log::error('Video processing failed.', [
            'video_uuid' => $event->video->uuid,
            'user_id' => $event->video->user_id,
            'failure_reason' => $event->video->failure_reason,
        ]);
    }
}
