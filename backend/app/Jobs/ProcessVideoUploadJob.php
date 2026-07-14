<?php

namespace App\Jobs;

use App\Contracts\VideoMetadataExtractor;
use App\Enums\VideoStatus;
use App\Events\VideoProcessed;
use App\Events\VideoProcessingFailed;
use App\Exceptions\VideoProcessingException;
use App\Models\Video;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

/**
 * Turns a freshly uploaded (Pending) video into a Ready one: probes the file
 * for duration/dimensions and generates a thumbnail. Idempotent by design —
 * see the deterministic thumbnail path and `published_at ??=` below — so a
 * retry after a partial failure is safe and does not require a separate
 * idempotency-key store.
 */
class ProcessVideoUploadJob implements ShouldQueue
{
    use Queueable;

    /**
     * Processing calls out to an external binary and touches the filesystem —
     * both can fail transiently (disk contention, momentary resource limits).
     * Five attempts with growing backoff absorbs that without hammering the
     * system; permanent failures (see VideoProcessingException::isPermanent())
     * short-circuit via $this->fail() long before these are exhausted.
     */
    public int $tries = 5;

    public array $backoff = [10, 30, 60, 120, 300];

    /**
     * Generous ceiling for a single attempt — real-world video probing/thumbnailing
     * of large files can legitimately take a while; this bounds a truly stuck
     * process rather than typical processing time.
     */
    public int $timeout = 300;

    public function __construct(public readonly Video $video)
    {
    }

    /**
     * Prevents two overloaded workers from ever processing the same video
     * concurrently (e.g. a slow attempt still running when a retry fires).
     */
    public function middleware(): array
    {
        return [(new WithoutOverlapping((string) $this->video->id))->releaseAfter(5)];
    }

    public function handle(VideoMetadataExtractor $extractor): void
    {
        $this->video->forceFill(['status' => VideoStatus::Processing])->save();

        $disk = $this->video->disk;
        [$videoPath, $isTemporaryVideoCopy] = $this->resolveLocalPath($disk, $this->video->path);

        try {
            $probe = $extractor->probe($videoPath);

            $thumbnailRelativePath = "thumbnails/{$this->video->uuid}.jpg";
            [$thumbnailPath, $isTemporaryThumbnail] = $this->resolveThumbnailWorkingPath($disk, $thumbnailRelativePath);

            $extractor->generateThumbnail($videoPath, $thumbnailPath);

            if ($isTemporaryThumbnail) {
                Storage::disk($disk)->put($thumbnailRelativePath, file_get_contents($thumbnailPath));
                @unlink($thumbnailPath);
            }

            $this->video->forceFill([
                'duration_seconds' => $probe->durationSeconds,
                'width' => $probe->width,
                'height' => $probe->height,
                'thumbnail_path' => $thumbnailRelativePath,
                'status' => VideoStatus::Ready,
                // Only set on first success: a retry after a partial failure must not
                // bump the publish timestamp forward.
                'published_at' => $this->video->published_at ?? now(),
            ])->save();

            event(new VideoProcessed($this->video));
        } catch (VideoProcessingException $e) {
            if ($e->isPermanent()) {
                // Consumes exactly one attempt and invokes failed() synchronously
                // without rethrowing — retrying a corrupt/unsupported file would
                // never succeed, so there's no point burning the retry budget.
                $this->fail($e);

                return;
            }

            // Transient: rethrow so the queue's tries/backoff retry normally.
            throw $e;
        } finally {
            if ($isTemporaryVideoCopy) {
                @unlink($videoPath);
            }
        }
    }

    /**
     * Reached both by the manual $this->fail() call above (permanent failures)
     * and automatically once retries are exhausted (transient failures) — kept
     * as the single place that updates the row and fires the failure event.
     */
    public function failed(?Throwable $e): void
    {
        $this->video->forceFill([
            'status' => VideoStatus::Failed,
            'failure_reason' => Str::limit($e?->getMessage() ?? 'Unknown processing failure.', 1000),
        ])->save();

        event(new VideoProcessingFailed($this->video));
    }

    /**
     * ffmpeg/ffprobe need a real local filesystem path. For local-driver disks
     * ('local' or 'public') the file already has one. For a remote disk (e.g. a
     * future 's3' disk) it must be downloaded to a temp file first.
     *
     * @return array{0: string, 1: bool} [absolute path, whether it's a temp file the caller must clean up]
     */
    private function resolveLocalPath(string $disk, string $path): array
    {
        if (config("filesystems.disks.{$disk}.driver") === 'local') {
            return [Storage::disk($disk)->path($path), false];
        }

        // TODO(s3): for very large files, stream a byte-range instead of pulling the
        // whole object down before probing.
        $temp = tempnam(sys_get_temp_dir(), 'video_upload_');
        file_put_contents($temp, Storage::disk($disk)->get($path));

        return [$temp, true];
    }

    /**
     * Where ffmpeg should write the thumbnail it generates. For local-driver
     * disks this is the final destination directly; for a remote disk it's a
     * temp file that the caller then uploads and removes.
     *
     * @return array{0: string, 1: bool} [absolute path, whether it's a temp file the caller must upload+clean up]
     */
    private function resolveThumbnailWorkingPath(string $disk, string $relativePath): array
    {
        if (config("filesystems.disks.{$disk}.driver") === 'local') {
            // ffmpeg writes directly to this path (bypassing the Storage facade), so
            // the destination directory must already exist.
            Storage::disk($disk)->makeDirectory(dirname($relativePath));

            return [Storage::disk($disk)->path($relativePath), false];
        }

        return [tempnam(sys_get_temp_dir(), 'video_thumb_'), true];
    }
}
