<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Fired at most once per (video, viewer-fingerprint) per dedupe window — see
 * VideoService::recordView(). Carries only scalars, not the Video model:
 * its sole listener performs a raw atomic increment by id and has no need
 * of the rest of the row.
 */
class VideoViewed
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public readonly int $videoId,
        public readonly ?int $viewerId,
        public readonly string $viewerFingerprint,
    ) {
    }
}
