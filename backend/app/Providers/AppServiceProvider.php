<?php

namespace App\Providers;

use App\Contracts\VideoMetadataExtractor;
use App\Services\FfmpegVideoMetadataExtractor;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(VideoMetadataExtractor::class, fn () => new FfmpegVideoMetadataExtractor(
            ffprobeBinary: config('videos.ffprobe_binary'),
            ffmpegBinary: config('videos.ffmpeg_binary'),
            timeoutSeconds: config('videos.processing_timeout_seconds'),
        ));
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // bootstrap/app.php never calls ->throttleApi(), so these limiters don't
        // exist yet anywhere else; defined here so routes/api/videos.php can use
        // 'throttle:api' and 'throttle:video-uploads'.
        RateLimiter::for('api', function ($request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        RateLimiter::for('video-uploads', function ($request) {
            return Limit::perMinute(5)->by($request->user()?->id ?: $request->ip());
        });
    }
}
