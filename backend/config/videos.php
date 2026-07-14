<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Storage Disk
    |--------------------------------------------------------------------------
    |
    | Which filesystem disk (see config/filesystems.php) uploaded video files
    | and generated thumbnails are stored on. A single env var lets production
    | switch to "s3" (+ CDN) without any code changes.
    |
    */
    'disk' => env('VIDEO_DISK', 'public'),

    /*
    |--------------------------------------------------------------------------
    | Upload Constraints
    |--------------------------------------------------------------------------
    */
    'max_upload_size_kb' => (int) env('VIDEO_MAX_UPLOAD_SIZE_KB', 204800), // 200 MB
    'allowed_mime_types' => ['video/mp4', 'video/quicktime', 'video/webm', 'video/x-matroska'],

    /*
    |--------------------------------------------------------------------------
    | View Counting
    |--------------------------------------------------------------------------
    |
    | How long a single viewer's view is "remembered" before another view from
    | the same viewer on the same video is allowed to count again.
    |
    */
    'view_dedupe_ttl_minutes' => (int) env('VIDEO_VIEW_DEDUPE_TTL_MINUTES', 30),

    /*
    |--------------------------------------------------------------------------
    | Public Feed Cache
    |--------------------------------------------------------------------------
    |
    | Only the first (cursor-less) page of the public feed is cached, since
    | it's the single hottest, most-repeated query and the only page with a
    | stable, well-defined cache key.
    |
    */
    'feed_cache_key' => 'videos:public-feed:first-page',
    'feed_cache_ttl_seconds' => (int) env('VIDEO_FEED_CACHE_TTL_SECONDS', 60),

    /*
    |--------------------------------------------------------------------------
    | Processing Binaries
    |--------------------------------------------------------------------------
    */
    'ffprobe_binary' => env('FFPROBE_BINARY', 'ffprobe'),
    'ffmpeg_binary' => env('FFMPEG_BINARY', 'ffmpeg'),
    'processing_timeout_seconds' => (int) env('VIDEO_PROCESSING_TIMEOUT_SECONDS', 120),
];
