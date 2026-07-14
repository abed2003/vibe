<?php

namespace Tests\Unit\Listeners;

use App\Events\VideoViewed;
use App\Listeners\IncrementVideoViewsCount;
use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IncrementVideoViewsCountTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_atomically_increments_the_views_count(): void
    {
        $video = Video::factory()->ready()->create(['views_count' => 0]);

        (new IncrementVideoViewsCount())->handle(new VideoViewed($video->id, null, 'guest-fingerprint'));
        (new IncrementVideoViewsCount())->handle(new VideoViewed($video->id, null, 'another-fingerprint'));

        $this->assertSame(2, $video->fresh()->views_count);
    }
}
