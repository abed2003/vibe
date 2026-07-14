<?php

namespace Tests\Unit\Jobs;

use App\Contracts\VideoMetadataExtractor;
use App\Enums\VideoStatus;
use App\Events\VideoProcessed;
use App\Events\VideoProcessingFailed;
use App\Exceptions\VideoProcessingException;
use App\Jobs\ProcessVideoUploadJob;
use App\Models\Video;
use App\Support\VideoProbeResult;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use Tests\Support\Fakes\FakeVideoMetadataExtractor;
use Tests\TestCase;

/**
 * These tests dispatch the job for real (ProcessVideoUploadJob::dispatch())
 * rather than instantiating it and calling ->handle() directly. That matters:
 * $this->fail() (used for the permanent-failure branch) is only meaningful
 * when the job is bound to a real underlying queue job — under a bare
 * ->handle() call it would silently no-op. QUEUE_CONNECTION=sync (set in
 * phpunit.xml) makes dispatch() run synchronously in-process, so this is
 * still a fast, isolated unit test — just one that exercises the real queue
 * plumbing instead of bypassing it.
 */
class ProcessVideoUploadJobTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
    }

    private function pendingVideo(): Video
    {
        $video = Video::factory()->create(['disk' => 'public']);
        Storage::disk('public')->put($video->path, 'fake-video-bytes');

        return $video;
    }

    private function bindExtractor(FakeVideoMetadataExtractor $extractor): void
    {
        $this->app->instance(VideoMetadataExtractor::class, $extractor);
    }

    public function test_dispatch_marks_video_ready_and_fills_metadata_on_success(): void
    {
        Event::fake([VideoProcessed::class]);

        $video = $this->pendingVideo();

        $this->bindExtractor(new FakeVideoMetadataExtractor(new VideoProbeResult(
            durationSeconds: 30,
            width: 1080,
            height: 1920,
        )));

        ProcessVideoUploadJob::dispatch($video);

        $video->refresh();

        $this->assertSame(VideoStatus::Ready, $video->status);
        $this->assertSame(30, $video->duration_seconds);
        $this->assertSame(1080, $video->width);
        $this->assertSame(1920, $video->height);
        $this->assertSame("thumbnails/{$video->uuid}.jpg", $video->thumbnail_path);
        $this->assertNotNull($video->published_at);
        Storage::disk('public')->assertExists($video->thumbnail_path);

        Event::assertDispatched(VideoProcessed::class, fn (VideoProcessed $event) => $event->video->uuid === $video->uuid);
    }

    public function test_dispatch_does_not_overwrite_an_existing_published_at_on_reprocessing(): void
    {
        $video = $this->pendingVideo();
        $originalPublishedAt = now()->subDay()->startOfSecond();
        $video->forceFill(['published_at' => $originalPublishedAt])->save();

        $this->bindExtractor(new FakeVideoMetadataExtractor());

        ProcessVideoUploadJob::dispatch($video->fresh());

        $this->assertTrue($video->fresh()->published_at->equalTo($originalPublishedAt));
    }

    public function test_permanent_failure_marks_video_failed_without_propagating(): void
    {
        Event::fake([VideoProcessingFailed::class]);

        $video = $this->pendingVideo();
        $this->bindExtractor(
            (new FakeVideoMetadataExtractor())->failProbeWith(VideoProcessingException::permanent('corrupt file'))
        );

        // Should not throw: permanent failures are fully handled internally.
        ProcessVideoUploadJob::dispatch($video);

        $video->refresh();

        $this->assertSame(VideoStatus::Failed, $video->status);
        $this->assertSame('corrupt file', $video->failure_reason);

        Event::assertDispatched(VideoProcessingFailed::class, fn (VideoProcessingFailed $event) => $event->video->uuid === $video->uuid);
    }

    public function test_transient_failure_propagates_and_is_recorded_under_the_sync_queue(): void
    {
        Event::fake([VideoProcessingFailed::class]);

        $video = $this->pendingVideo();
        $this->bindExtractor(
            (new FakeVideoMetadataExtractor())->failProbeWith(VideoProcessingException::transient('disk busy'))
        );

        // Under a real async queue this would be retried per $tries/$backoff before
        // ever reaching this state. QUEUE_CONNECTION=sync has no such retry: any
        // exception is treated as an immediately-exhausted attempt, which is why
        // the video ends up Failed here in the same call that also rethrows.
        try {
            ProcessVideoUploadJob::dispatch($video);
            $this->fail('Expected a VideoProcessingException to propagate.');
        } catch (VideoProcessingException $e) {
            $this->assertSame('disk busy', $e->getMessage());
        }

        $this->assertSame(VideoStatus::Failed, $video->fresh()->status);
        Event::assertDispatched(VideoProcessingFailed::class);
    }
}
