<?php

namespace App\Providers;

use App\Contracts\VideoMetadataExtractor;
use App\Services\FfmpegVideoMetadataExtractor;
use App\Services\NullVideoMetadataExtractor;
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
        $this->app->bind(VideoMetadataExtractor::class, function () {
            $ffprobeBinary = config('videos.ffprobe_binary');
            $ffmpegBinary = config('videos.ffmpeg_binary');

            // Dev machines without the ffmpeg/ffprobe binaries installed fall
            // back to a null extractor so uploads still complete (Ready, no
            // thumbnail) instead of failing; production keeps the real one.
            if (! self::binaryAvailable($ffprobeBinary) || ! self::binaryAvailable($ffmpegBinary)) {
                return new NullVideoMetadataExtractor();
            }

            return new FfmpegVideoMetadataExtractor(
                ffprobeBinary: $ffprobeBinary,
                ffmpegBinary: $ffmpegBinary,
                timeoutSeconds: config('videos.processing_timeout_seconds'),
            );
        });
    }

    /**
     * Whether an executable with this name can be launched: either a direct
     * path or resolvable through the PATH entries (with Windows extensions).
     */
    private static function binaryAvailable(string $binary): bool
    {
        if (is_executable($binary)) {
            return true;
        }

        $isWindows = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
        $extensions = $isWindows ? ['.exe', '.bat', '.cmd', ''] : [''];

        foreach (explode(PATH_SEPARATOR, (string) getenv('PATH')) as $path) {
            if ($path === '') {
                continue;
            }

            foreach ($extensions as $extension) {
                if (is_executable($path.DIRECTORY_SEPARATOR.$binary.$extension)) {
                    return true;
                }
            }
        }

        return false;
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
