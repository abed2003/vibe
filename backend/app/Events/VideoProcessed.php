<?php

namespace App\Events;

use App\Models\Video;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Fired once ProcessVideoUploadJob has successfully probed the file,
 * generated a thumbnail, and flipped the video to Ready.
 */
class VideoProcessed
{
    use Dispatchable, SerializesModels;

    public function __construct(public readonly Video $video)
    {
    }
}
