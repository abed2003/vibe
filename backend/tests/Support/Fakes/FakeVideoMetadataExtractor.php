<?php

namespace Tests\Support\Fakes;

use App\Contracts\VideoMetadataExtractor;
use App\Exceptions\VideoProcessingException;
use App\Support\VideoProbeResult;

/**
 * Test double for VideoMetadataExtractor. Lets tests exercise the full
 * upload -> process -> ready/failed pipeline without the ffmpeg/ffprobe
 * binaries actually being installed. Instance-based (not static flags) so
 * each test gets an isolated, independently configurable fake.
 */
class FakeVideoMetadataExtractor implements VideoMetadataExtractor
{
    private ?VideoProcessingException $probeException = null;

    private ?VideoProcessingException $thumbnailException = null;

    private VideoProbeResult $probeResult;

    public function __construct(?VideoProbeResult $probeResult = null)
    {
        $this->probeResult = $probeResult ?? new VideoProbeResult(
            durationSeconds: 42,
            width: 1080,
            height: 1920,
        );
    }

    public function failProbeWith(VideoProcessingException $exception): static
    {
        $this->probeException = $exception;

        return $this;
    }

    public function failThumbnailWith(VideoProcessingException $exception): static
    {
        $this->thumbnailException = $exception;

        return $this;
    }

    public function probe(string $absolutePath): VideoProbeResult
    {
        if ($this->probeException !== null) {
            throw $this->probeException;
        }

        return $this->probeResult;
    }

    public function generateThumbnail(string $absoluteVideoPath, string $absoluteThumbnailPath, float $atSecond = 1.0): void
    {
        if ($this->thumbnailException !== null) {
            throw $this->thumbnailException;
        }

        file_put_contents($absoluteThumbnailPath, 'fake-thumbnail-bytes');
    }
}
