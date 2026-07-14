# Video Feature — Optimization Notes

This document explains the non-obvious architectural decisions behind the Video feature (`app/Models/Video.php` and everything wired around it) and why each one was made. It's aimed at whoever touches this code next, so they can extend it without accidentally undoing the reasoning below.

## Public identifier: ULID, not the auto-increment id

`Video` exposes a `uuid` column (actually a ULID: `Str::ulid()`) as its public identifier — `getRouteKeyName()` returns `'uuid'`, and it's the only identifier `VideoResource` serializes. The internal auto-increment `id` never leaves the backend.

Two reasons this beats exposing the raw id directly:

- **No enumeration.** Sequential ids let anyone estimate total upload volume and iterate over `/api/videos/1`, `/2`, `/3`, ... A ULID gives no such signal.
- **No enumeration, but still sortable.** A UUIDv4 would solve the first problem but be random-order; a ULID encodes its creation timestamp in its first 48 bits, so it sorts chronologically like the auto-increment id would, without exposing the id itself. That property isn't exploited today, but it means the identifier can double as a natural cursor if a future endpoint needs one.

## Denormalized `views_count`

A view is recorded via `VideoService::recordView()`, which:

1. Dedupes with `Cache::add("videos:{uuid}:viewed:{fingerprint}", true, ttl)` — an atomic "set only if absent," so two concurrent requests from the same viewer can't both win the race and both count.
2. Only then fires `VideoViewed`, whose sole listener (`IncrementVideoViewsCount`, queued) does `DB::table('videos')->where('id', ...)->increment('views_count')`.

Three trade-offs bundled into that one design:

- **O(1) reads.** The feed and show endpoints never run `COUNT()` against a separate views/impressions table — they just read a column.
- **Race-free writes.** The atomic SQL `increment()` (not "read count, add one, write back") means concurrent viewers can never clobber each other's increment.
- **Bounded eventual consistency.** Because the increment is queued, the HTTP response for a `show` request may briefly show the pre-increment count. This is deliberate: view counts are not a correctness-critical field (nobody's account balance depends on them), so trading strict consistency for keeping counts off the request's hot path is the right call. Tests assert this by checking the database row after the request, not the JSON response body.

## String-backed enums, not native DB enum columns

`status` and `visibility` are plain `string` columns at the schema level, cast to `App\Enums\VideoStatus` / `App\Enums\VideoVisibility` (PHP backed enums) at the Eloquent layer — not a MySQL/Postgres native `ENUM(...)` column type.

This means adding a new status or visibility value later (e.g. a `Scheduled` status, or a `FollowersOnly` visibility) is a pure application deploy: add a case to the enum, ship it. A native DB enum column would require an actual migration (and, on MySQL, an often-costly `ALTER TABLE`) for the same change. The string column is also portable as-is across the sqlite (dev) / MySQL / Postgres boundary, where native enum syntax differs or doesn't exist.

## Soft deletes

`Video` uses `SoftDeletes`. A creator's delete request needs to be fast and (within a window) reversible — for accidental deletes, and for moderation appeals. `VideoService::delete()` only soft-deletes; it deliberately does not touch the underlying file on disk. Physical file removal is left to a future scheduled command (e.g. `videos:purge-trashed`) that runs after the moderation/undo window has passed. This keeps the delete endpoint's latency and failure modes independent of storage-backend behavior.

## Indexing strategy

Two composite indexes on `videos`, each matching an actual query the feature runs:

- `(visibility, status, published_at)` — serves the public feed: `WHERE visibility = 'public' AND status = 'ready' ORDER BY published_at DESC`. All three columns are in the index, in the order the query filters/sorts by, so the database can satisfy the whole query from the index without a separate sort step.
- `(user_id, created_at)` — serves a user's own profile/upload list: `WHERE user_id = ? ORDER BY created_at DESC`.

Neither index exists speculatively — both are load-bearing for a query that ships in this PR.

## `QUEUE_CONNECTION` must not be `sync` in production, specifically because of this feature

Locally and in tests, `QUEUE_CONNECTION=sync` runs queued jobs and listeners in-process, synchronously, which is convenient and requires no worker process. But it has a real consequence here: `VideoService::upload()` fires `VideoUploaded` synchronously from inside the `store` HTTP action. Under `sync`, that event's listener (`DispatchVideoProcessingJob`) runs `ProcessVideoUploadJob` — which shells out to ffmpeg/ffprobe — **inside the same request**. A slow or transiently-failing probe would otherwise turn into upload-request latency or a 500, even though the video row was already correctly persisted.

`DispatchVideoProcessingJob` guards against exactly this with a `try/catch (\Throwable $e) { report($e); }` around the dispatch, so a background-processing hiccup can never crash the upload response even under `sync`. But that guard is a safety net, not a substitute for running this feature on a real queue in production:

- Use `redis` or `sqs` (or another proper broker) so `store()` returns as soon as the file is saved and the row is created, independent of how long transcoding takes.
- Route `ProcessVideoUploadJob` to a **dedicated queue**, separate from the lightweight listeners (`BustPublicFeedCache`, `IncrementVideoViewsCount`). ffmpeg/ffprobe work is CPU- and I/O-heavy and can take seconds; without a separate queue, a burst of uploads would starve view-count increments and cache invalidation behind a backlog of transcoding jobs.

## Cursor pagination for the public feed, not offset

`VideoController::index()` uses `cursorPaginate()`, not `paginate()`. Offset pagination (`LIMIT x OFFSET y`) degrades as `y` grows — the database still has to walk past `y` rows — and is unstable under concurrent writes: if a new video publishes between two page requests, `OFFSET`-based paging can skip or duplicate rows for a scrolling user. Cursor pagination reads `WHERE published_at < ?` (using the last row's cursor value) and is O(page size) via the existing `(visibility, status, published_at)` index regardless of how deep the feed is, and is stable regardless of concurrent inserts — a newly published video changes the front of the feed, not the position of rows a scrolling client has already seen.

Only the first (cursor-less) page is cached (`Cache::remember(config('videos.feed_cache_key'), ...)`), because it's the one page with a single well-defined, reusable cache key and the one every cold app-open requests. Any request that supplies a `cursor` reads straight from the database — there's no bounded set of cache keys for "every possible scroll position," so caching is deliberately scoped to the one case where it's unambiguous and highest-value.

## Disk / CDN strategy

Storage is accessed exclusively through `config('videos.disk')` (env: `VIDEO_DISK`, default `public`) rather than being hardcoded anywhere. In dev this points at Laravel's local `public` disk. In production, setting `VIDEO_DISK=s3` (with the existing `s3` disk block in `config/filesystems.php`) is the only change needed to move storage — and, from there, a CDN (CloudFront or similar) in front of the S3 bucket — with zero code changes, since every read/write goes through the `Storage::disk($this->disk)` abstraction rather than assuming a local path.

`ProcessVideoUploadJob` already has the extension point for this: `resolveLocalPath()`/`resolveThumbnailWorkingPath()` branch on the disk's `driver` config value, using the file directly for local-driver disks and falling back to a temp-file download/upload round-trip for anything else (annotated with a `TODO(s3)` for streaming a byte range instead of pulling the whole object down, which matters once videos are large).

## N+1 avoidance

The feed query eager-loads the uploader (`->with('user')`), and `VideoResource` only serializes the `owner` field via `whenLoaded('user')` — if a caller ever queries videos without eager-loading `user`, the resource silently omits `owner` rather than lazy-loading it per row. This makes an N+1 structurally hard to introduce by accident: the failure mode is a missing field, not a silent performance cliff.

## Job idempotency

`ProcessVideoUploadJob` can be retried (transient failures get up to 5 attempts with growing backoff: 10s, 30s, 60s, 120s, 300s). Retrying is safe without any separate idempotency-key bookkeeping, because of three small, deliberate details:

- The thumbnail path is **deterministic** (`thumbnails/{uuid}.jpg`), and ffmpeg is invoked with `-y` (overwrite). A retry regenerates and overwrites the same file rather than accumulating orphaned thumbnails.
- `published_at` is only set if it isn't already set (`$this->video->published_at ?? now()`). A retry after a partial failure (e.g. probing succeeded, thumbnail generation crashed) doesn't push the publish timestamp forward on the second attempt.
- Permanent failures (`VideoProcessingException::permanent()` — corrupt/unsupported file) short-circuit via `$this->fail($e)` on the first attempt rather than retrying at all; retrying a file that will never successfully probe just delays the user seeing a failure and wastes queue capacity for no chance of a different outcome.
