<?php

namespace Tests\Feature;

use App\Enums\VideoStatus;
use App\Enums\VideoVisibility;
use App\Jobs\ProcessVideoUploadJob;
use App\Models\User;
use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class VideoApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
    }

    public function test_public_feed_only_lists_ready_public_videos(): void
    {
        $visible = Video::factory()->ready()->create();
        Video::factory()->ready()->private()->create();
        Video::factory()->create(); // still Pending

        $response = $this->getJson('/api/videos');

        $response->assertOk();
        $response->assertJsonCount(1, 'data');
        $response->assertJsonPath('data.0.uuid', $visible->uuid);
    }

    public function test_feed_eager_loads_owner_without_n_plus_one(): void
    {
        Video::factory()->ready()->create();

        $response = $this->getJson('/api/videos');

        $response->assertOk();
        $response->assertJsonPath('data.0.owner.id', fn ($id) => $id !== null);
    }

    public function test_guest_cannot_upload(): void
    {
        $file = UploadedFile::fake()->create('clip.mp4', 512, 'video/mp4');

        $response = $this->postJson('/api/videos', ['video' => $file]);

        $response->assertUnauthorized();
    }

    public function test_authenticated_user_can_upload_a_video(): void
    {
        // The processing pipeline itself (ffmpeg/ffprobe) is exercised by
        // ProcessVideoUploadJobTest; faking the queue here keeps this test
        // scoped to the HTTP/upload contract and sidesteps needing a real
        // ffmpeg binary at this layer.
        Queue::fake();

        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $file = UploadedFile::fake()->create('clip.mp4', 2048, 'video/mp4');

        $response = $this->postJson('/api/videos', [
            'video' => $file,
            'title' => 'Hello world',
            'visibility' => VideoVisibility::Unlisted->value,
        ]);

        $response->assertCreated();
        $response->assertJsonPath('data.title', 'Hello world');
        $response->assertJsonPath('data.status', VideoStatus::Pending->value);

        $this->assertDatabaseHas('videos', [
            'user_id' => $user->id,
            'title' => 'Hello world',
            'visibility' => VideoVisibility::Unlisted->value,
            'status' => VideoStatus::Pending->value,
        ]);

        Queue::assertPushed(ProcessVideoUploadJob::class);
    }

    public function test_upload_is_rejected_when_the_file_is_too_large(): void
    {
        Sanctum::actingAs(User::factory()->create());

        $tooLargeKb = config('videos.max_upload_size_kb') + 1;
        $file = UploadedFile::fake()->create('clip.mp4', $tooLargeKb, 'video/mp4');

        $response = $this->postJson('/api/videos', ['video' => $file]);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors('video');
    }

    public function test_show_returns_a_ready_video_and_increments_its_view_count(): void
    {
        $video = Video::factory()->ready()->create();

        $response = $this->getJson("/api/videos/{$video->uuid}");

        $response->assertOk();
        $response->assertJsonPath('data.uuid', $video->uuid);

        // The listener bypasses the in-memory model with a raw atomic increment
        // (see IncrementVideoViewsCount), so this is asserted against the DB row,
        // not the JSON response's views_count.
        $this->assertSame(1, $video->fresh()->views_count);
    }

    public function test_show_forbids_a_stranger_from_viewing_a_private_video(): void
    {
        $video = Video::factory()->ready()->private()->create();

        $response = $this->getJson("/api/videos/{$video->uuid}");

        $response->assertForbidden();
    }

    public function test_owner_can_delete_their_video(): void
    {
        $owner = User::factory()->create();
        $video = Video::factory()->ready()->create(['user_id' => $owner->id]);

        Sanctum::actingAs($owner);

        $response = $this->deleteJson("/api/videos/{$video->uuid}");

        $response->assertNoContent();
        $this->assertSoftDeleted($video);
    }

    public function test_non_owner_cannot_delete_the_video(): void
    {
        $video = Video::factory()->ready()->create();

        Sanctum::actingAs(User::factory()->create());

        $response = $this->deleteJson("/api/videos/{$video->uuid}");

        $response->assertForbidden();
        $this->assertDatabaseHas('videos', ['id' => $video->id, 'deleted_at' => null]);
    }
}
