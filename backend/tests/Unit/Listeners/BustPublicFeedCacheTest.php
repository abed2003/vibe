<?php

namespace Tests\Unit\Listeners;

use App\Events\VideoProcessed;
use App\Listeners\BustPublicFeedCache;
use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class BustPublicFeedCacheTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_forgets_the_public_feed_cache_key(): void
    {
        Cache::put(config('videos.feed_cache_key'), 'stale-feed-payload', 60);

        (new BustPublicFeedCache())->handle(new VideoProcessed(Video::factory()->ready()->create()));

        $this->assertNull(Cache::get(config('videos.feed_cache_key')));
    }
}
