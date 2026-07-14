<?php

namespace App\Providers;

use App\Events\VideoProcessed;
use App\Events\VideoProcessingFailed;
use App\Events\VideoUploaded;
use App\Events\VideoViewed;
use App\Listeners\BustPublicFeedCache;
use App\Listeners\DispatchVideoProcessingJob;
use App\Listeners\IncrementVideoViewsCount;
use App\Listeners\LogVideoProcessingFailure;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

/**
 * Laravel 11 no longer registers an EventServiceProvider by default (or
 * auto-discovers listeners without explicitly disabling scanning), so this
 * is created and wired in manually via bootstrap/providers.php.
 *
 * An explicit $listen map is used instead of listener auto-discovery: it's
 * greppable (a new developer can see every wire-up in one place), and it's
 * trivially assertable in tests with Event::assertListening(), independent
 * of QUEUE_CONNECTION.
 */
class EventServiceProvider extends ServiceProvider
{
    /**
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        VideoUploaded::class => [
            DispatchVideoProcessingJob::class,
        ],
        VideoProcessed::class => [
            BustPublicFeedCache::class,
        ],
        VideoProcessingFailed::class => [
            LogVideoProcessingFailure::class,
        ],
        VideoViewed::class => [
            IncrementVideoViewsCount::class,
        ],
    ];

    /**
     * Disables Laravel's reflection-based auto-discovery of listeners: the
     * $listen map above is the single source of truth.
     */
    protected static $shouldDiscoverEvents = false;
}
