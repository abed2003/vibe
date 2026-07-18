<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVideoRequest;
use App\Http\Resources\VideoResource;
use App\Models\Video;
use App\Services\VideoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class VideoController extends Controller
{
    public function __construct(private readonly VideoService $videos)
    {
    }

    /**
     * The public feed. Cursor-paginated rather than offset-paginated: offset
     * pagination degrades (OFFSET n) as the feed grows and is unstable under
     * concurrent inserts (skipped/duplicated rows as new videos publish
     * mid-scroll), whereas cursor pagination is O(1) per page via the
     * (visibility, status, published_at) index and stable regardless of
     * concurrent writes.
     *
     * Only the no-cursor (first) page is cached: it's the single hottest,
     * most-repeated query (every cold app open) and the only page with a
     * stable, well-defined cache key. Any request with a `cursor` param reads
     * straight through to the database.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $search = trim((string) $request->query('search', ''));
        $viewer = $request->user();

        $query = fn () => Video::publiclyVisible()
            ->with('user')
            ->when($viewer, fn ($q) => $q->withExists([
                'likes as liked_by_me' => fn ($lq) => $lq->where('user_id', $viewer->id),
                'saves as saved_by_me' => fn ($sq) => $sq->where('user_id', $viewer->id),
            ]))
            // Case-insensitive substring match on title/description; LOWER()
            // keeps this portable across Postgres/MySQL/SQLite (unlike ILIKE).
            ->when($search !== '', function ($q) use ($search) {
                $term = '%'.mb_strtolower($search).'%';

                return $q->where(fn ($sq) => $sq
                    ->whereRaw('LOWER(title) LIKE ?', [$term])
                    ->orWhereRaw('LOWER(description) LIKE ?', [$term]));
            })
            ->latest('published_at')
            ->cursorPaginate(15);

        // Only the no-cursor, unfiltered first page is cached (see the class
        // docblock): search results and later pages read straight through.
        $paginator = ($request->has('cursor') || $search !== '')
            ? $query()
            : Cache::remember(config('videos.feed_cache_key'), config('videos.feed_cache_ttl_seconds'), $query);

        return VideoResource::collection($paginator);
    }

    public function store(StoreVideoRequest $request): JsonResponse
    {
        $video = $this->videos->upload(
            $request->user(),
            $request->file('video'),
            $request->validated(),
        );

        return (new VideoResource($video))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Request $request, Video $video): VideoResource
    {
        $this->authorize('view', $video);

        $viewer = $request->user();

        if ($viewer) {
            $video->loadExists([
                'likes as liked_by_me' => fn ($lq) => $lq->where('user_id', $viewer->id),
                'saves as saved_by_me' => fn ($sq) => $sq->where('user_id', $viewer->id),
            ]);
        }

        $fingerprint = $viewer
            ? (string) $viewer->id
            : hash('sha256', $request->ip().'|'.$request->userAgent());

        $this->videos->recordView($video, $viewer, $fingerprint);

        return new VideoResource($video->load('user'));
    }

    public function destroy(Request $request, Video $video): Response
    {
        $this->authorize('delete', $video);

        $this->videos->delete($video);

        return response()->noContent();
    }
}
