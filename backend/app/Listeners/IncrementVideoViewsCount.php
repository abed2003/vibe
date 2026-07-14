<?php

namespace App\Listeners;

use App\Events\VideoViewed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;

/**
 * Queued so view-count writes never sit on the show-video request's critical
 * path even under viral traffic. Uses a raw atomic SQL increment (rather than
 * reading the model's current count and writing count+1) specifically to
 * avoid a read-modify-write race between concurrent viewers of the same video.
 */
class IncrementVideoViewsCount implements ShouldQueue
{
    public function handle(VideoViewed $event): void
    {
        DB::table('videos')->where('id', $event->videoId)->increment('views_count');
    }
}
