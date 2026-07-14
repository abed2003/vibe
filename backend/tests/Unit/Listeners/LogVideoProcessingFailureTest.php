<?php

namespace Tests\Unit\Listeners;

use App\Events\VideoProcessingFailed;
use App\Listeners\LogVideoProcessingFailure;
use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class LogVideoProcessingFailureTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_logs_the_failure_with_context(): void
    {
        $video = Video::factory()->failed()->create();

        Log::shouldReceive('error')
            ->once()
            ->with('Video processing failed.', [
                'video_uuid' => $video->uuid,
                'user_id' => $video->user_id,
                'failure_reason' => $video->failure_reason,
            ]);

        (new LogVideoProcessingFailure())->handle(new VideoProcessingFailed($video));
    }
}
