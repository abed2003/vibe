<?php

namespace Tests\Unit\Listeners;

use App\Contracts\VideoMetadataExtractor;
use App\Enums\VideoStatus;
use App\Events\VideoUploaded;
use App\Exceptions\VideoProcessingException;
use App\Jobs\ProcessVideoUploadJob;
use App\Listeners\DispatchVideoProcessingJob;
use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;
use Tests\Support\Fakes\FakeVideoMetadataExtractor;
use Tests\TestCase;

class DispatchVideoProcessingJobTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_dispatches_the_processing_job_for_the_uploaded_video(): void
    {
        Queue::fake();

        $video = Video::factory()->create();

        (new DispatchVideoProcessingJob())->handle(new VideoUploaded($video));

        Queue::assertPushed(ProcessVideoUploadJob::class, fn (ProcessVideoUploadJob $job) => $job->video->is($video));
    }

    public function test_a_transient_processing_exception_does_not_propagate_out_of_the_listener(): void
    {
        // Load-bearing under QUEUE_CONNECTION=sync (set in phpunit.xml): the job
        // actually runs synchronously inside dispatch() here, so without the
        // listener's try/catch this would bubble up and fail the test exactly as
        // it would otherwise crash the upload HTTP request in production.
        Storage::fake('public');
        $video = Video::factory()->create(['disk' => 'public']);
        Storage::disk('public')->put($video->path, 'bytes');

        $this->app->instance(VideoMetadataExtractor::class, (new FakeVideoMetadataExtractor())
            ->failProbeWith(VideoProcessingException::transient('disk busy')));

        (new DispatchVideoProcessingJob())->handle(new VideoUploaded($video));

        $this->assertSame(VideoStatus::Failed, $video->fresh()->status);
    }
}
