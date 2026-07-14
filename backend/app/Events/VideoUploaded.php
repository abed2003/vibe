<?php

namespace App\Events;

use App\Models\Video;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Fired once a video's file has been stored and its row created (status:
 * Pending). Deliberately decoupled from "processing has started" — anything
 * that cares about the raw fact of an upload (analytics, moderation
 * pre-screening, notifying followers) can subscribe independently of the
 * job that actually transcodes the file.
 */
class VideoUploaded
{
    use Dispatchable, SerializesModels;

    public function __construct(public readonly Video $video)
    {
    }
}
