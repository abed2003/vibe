<?php

namespace Tests\Unit\Services;

use App\Enums\VideoStatus;
use App\Enums\VideoVisibility;
use App\Events\VideoUploaded;
use App\Events\VideoViewed;
use App\Models\User;
use App\Models\Video;
use App\Services\VideoService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class VideoServiceTest extends TestCase
{
    use RefreshDatabase;

    private VideoService $service;

    protected function setUp(): void
    {
        parent::setUp();

        // Must match config('videos.disk') (default: 'public'), not the unrelated
        // FILESYSTEM_DISK=local default disk.
        Storage::fake('public');

        $this->service = app(VideoService::class);
    }

    public function test_upload_stores_the_file_and_creates_a_pending_video(): void
    {
        Event::fake([VideoUploaded::class]);

        $user = User::factory()->create();
        $file = UploadedFile::fake()->create('clip.mp4', 1024, 'video/mp4');

        $video = $this->service->upload($user, $file, [
            'title' => 'My clip',
            'visibility' => VideoVisibility::Unlisted,
        ]);

        $this->assertDatabaseHas('videos', [
            'id' => $video->id,
            'user_id' => $user->id,
            'title' => 'My clip',
            'visibility' => VideoVisibility::Unlisted->value,
            'status' => VideoStatus::Pending->value,
        ]);

        Storage::disk('public')->assertExists($video->path);
        $this->assertNotEmpty($video->uuid);
        $this->assertStringContainsString($video->uuid, $video->path);

        Event::assertDispatched(VideoUploaded::class, fn (VideoUploaded $event) => $event->video->is($video));
    }

    public function test_upload_defaults_visibility_to_public_when_not_provided(): void
    {
        $user = User::factory()->create();
        $file = UploadedFile::fake()->create('clip.mp4', 512, 'video/mp4');

        $video = $this->service->upload($user, $file);

        $this->assertSame(VideoVisibility::Public, $video->visibility);
    }

    public function test_record_view_fires_video_viewed_once_per_dedupe_window(): void
    {
        Event::fake([VideoViewed::class]);

        $video = Video::factory()->ready()->create();
        $viewer = User::factory()->create();

        $this->service->recordView($video, $viewer, (string) $viewer->id);
        $this->service->recordView($video, $viewer, (string) $viewer->id);

        Event::assertDispatchedTimes(VideoViewed::class, 1);
    }

    public function test_record_view_allows_different_viewers_independently(): void
    {
        Event::fake([VideoViewed::class]);

        $video = Video::factory()->ready()->create();
        $viewerA = User::factory()->create();
        $viewerB = User::factory()->create();

        $this->service->recordView($video, $viewerA, (string) $viewerA->id);
        $this->service->recordView($video, $viewerB, (string) $viewerB->id);

        Event::assertDispatchedTimes(VideoViewed::class, 2);
    }

    public function test_delete_soft_deletes_the_video(): void
    {
        $video = Video::factory()->ready()->create();

        $this->service->delete($video);

        $this->assertSoftDeleted($video);
    }
}
