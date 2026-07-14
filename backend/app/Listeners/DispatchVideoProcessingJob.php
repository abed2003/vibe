<?php

namespace App\Listeners;

use App\Events\VideoUploaded;
use App\Jobs\ProcessVideoUploadJob;
use Throwable;

/**
 * Turns the "a video was uploaded" domain fact into the actual processing
 * work. Kept as a distinct listener (rather than VideoService dispatching the
 * job directly) so VideoService::upload() stays focused purely on the
 * create-transaction, and so other future concerns (analytics, moderation
 * pre-screening) can subscribe to VideoUploaded independently without it
 * knowing or caring about them.
 *
 * Not a queued listener itself: dispatching a job is already a cheap,
 * in-process call, so an extra queue round-trip here would only add latency.
 */
class DispatchVideoProcessingJob
{
    public function handle(VideoUploaded $event): void
    {
        try {
            ProcessVideoUploadJob::dispatch($event->video);
        } catch (Throwable $e) {
            // Load-bearing, not decorative: under QUEUE_CONNECTION=sync (dev/test),
            // ProcessVideoUploadJob::handle() runs synchronously right here. An
            // uncaught transient VideoProcessingException would otherwise propagate
            // through this dispatch(), through the VideoUploaded event(), and all the
            // way back into VideoService::upload() — turning a background-processing
            // hiccup into a 500 on the upload HTTP request, even though the video row
            // is already correctly persisted (and, for permanent failures, already
            // marked Failed). On a real async queue connection this branch is simply
            // unreachable, since the job runs on a separate worker process.
            report($e);
        }
    }
}
