<?php

namespace App\Services;

use App\Contracts\VideoMetadataExtractor;
use App\Support\VideoProbeResult;

/**
 * Fallback extractor for environments without the ffmpeg/ffprobe binaries
 * (e.g. a minimal dev machine). Probe returns neutral metadata and thumbnail
 * generation is a no-op — the video still becomes Ready and playable, just
 * without probed dimensions or a poster frame. AppServiceProvider binds this
 * automatically when the binaries are not found on PATH; production machines
 * with ffmpeg installed keep the real FfmpegVideoMetadataExtractor.
 */
class NullVideoMetadataExtractor implements VideoMetadataExtractor
{
    public function probe(string $absolutePath): VideoProbeResult
    {
        return new VideoProbeResult(durationSeconds: 0, width: 0, height: 0);
    }

    public function generateThumbnail(string $absoluteVideoPath, string $absoluteThumbnailPath, float $atSecond = 1.0): void
    {
        // No ffmpeg → no frame extraction. The job still records the
        // thumbnail path; the frontend tolerates a missing poster.
    }
}
