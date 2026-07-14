<?php

namespace App\Support;

/**
 * Immutable result of probing a video file for its technical metadata.
 */
final readonly class VideoProbeResult
{
    public function __construct(
        public int $durationSeconds,
        public int $width,
        public int $height,
    ) {
    }
}
