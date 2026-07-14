<?php

namespace App\Services;

use App\Contracts\VideoMetadataExtractor;
use App\Exceptions\VideoProcessingException;
use App\Support\VideoProbeResult;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

/**
 * Shells out to the ffprobe/ffmpeg binaries via Symfony Process rather than
 * pulling in a dedicated composer wrapper package: it's two straightforward
 * command invocations, and going through Process directly keeps this class's
 * behavior (timeouts, exit codes, output capture) fully transparent rather
 * than hidden behind another library's abstraction.
 */
class FfmpegVideoMetadataExtractor implements VideoMetadataExtractor
{
    public function __construct(
        private readonly string $ffprobeBinary,
        private readonly string $ffmpegBinary,
        private readonly int $timeoutSeconds,
    ) {
    }

    public function probe(string $absolutePath): VideoProbeResult
    {
        $process = new Process([
            $this->ffprobeBinary,
            '-v', 'error',
            '-print_format', 'json',
            '-show_entries', 'format=duration:stream=width,height',
            '-select_streams', 'v:0',
            $absolutePath,
        ], timeout: $this->timeoutSeconds);

        $this->run($process, 'ffprobe');

        $payload = json_decode($process->getOutput(), associative: true);

        $duration = (float) ($payload['format']['duration'] ?? 0);
        $width = (int) ($payload['streams'][0]['width'] ?? 0);
        $height = (int) ($payload['streams'][0]['height'] ?? 0);

        if ($duration <= 0 || $width <= 0 || $height <= 0) {
            throw VideoProcessingException::permanent(
                "ffprobe returned incomplete metadata for [{$absolutePath}]: ".$process->getOutput()
            );
        }

        return new VideoProbeResult(
            durationSeconds: (int) round($duration),
            width: $width,
            height: $height,
        );
    }

    public function generateThumbnail(string $absoluteVideoPath, string $absoluteThumbnailPath, float $atSecond = 1.0): void
    {
        $process = new Process([
            $this->ffmpegBinary,
            '-y',
            '-ss', (string) $atSecond,
            '-i', $absoluteVideoPath,
            '-frames:v', '1',
            '-q:v', '2',
            $absoluteThumbnailPath,
        ], timeout: $this->timeoutSeconds);

        $this->run($process, 'ffmpeg');

        if (! is_file($absoluteThumbnailPath)) {
            throw VideoProcessingException::permanent(
                "ffmpeg reported success but did not produce a thumbnail at [{$absoluteThumbnailPath}]."
            );
        }
    }

    private function run(Process $process, string $tool): void
    {
        try {
            $process->run();
        } catch (\Throwable $e) {
            // The binary itself couldn't be launched (missing executable, permissions,
            // OS-level fork failure) — treat as transient since it may be an
            // environment hiccup rather than a property of this specific file.
            throw VideoProcessingException::transient("Failed to start {$tool}.", $e);
        }

        if (! $process->isSuccessful()) {
            throw VideoProcessingException::permanent(
                "{$tool} exited with status {$process->getExitCode()}: ".$process->getErrorOutput(),
                new ProcessFailedException($process)
            );
        }
    }
}
