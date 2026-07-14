<?php

namespace App\Events;

use App\Models\Video;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Fired when ProcessVideoUploadJob gives up on a video (permanently, or
 * after exhausting its retries). The video's status/failure_reason columns
 * are already updated by the time this fires.
 */
class VideoProcessingFailed
{
    use Dispatchable, SerializesModels;

    public function __construct(public readonly Video $video)
    {
    }
}
