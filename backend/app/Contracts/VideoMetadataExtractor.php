<?php

namespace App\Contracts;

use App\Exceptions\VideoProcessingException;
use App\Support\VideoProbeResult;

/**
 * Abstraction over probing a video file for its technical metadata and
 * generating a thumbnail from it. Bound to an ffmpeg/ffprobe-backed
 * implementation in production; swapped for a fake in tests so the
 * processing pipeline can be exercised without the ffmpeg/ffprobe binaries
 * actually being installed.
 */
interface VideoMetadataExtractor
{
    /**
     * @throws VideoProcessingException
     */
    public function probe(string $absolutePath): VideoProbeResult;

    /**
     * @throws VideoProcessingException
     */
    public function generateThumbnail(string $absoluteVideoPath, string $absoluteThumbnailPath, float $atSecond = 1.0): void;
}
