<?php

namespace App\Listeners;

use App\Events\VideoProcessed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Cache;

/**
 * A newly Ready video changes the public feed's first page, so the cached
 * copy (see VideoController::index()) must be invalidated. Queued: cache
 * invalidation isn't latency-sensitive for the job that triggers it.
 */
class BustPublicFeedCache implements ShouldQueue
{
    public function handle(VideoProcessed $event): void
    {
        Cache::forget(config('videos.feed_cache_key'));
    }
}
