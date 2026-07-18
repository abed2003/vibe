<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    /**
     * Idempotent: liking an already-liked video is a no-op, so double submits
     * and optimistic-update replays can't inflate the counter.
     */
    public function store(Request $request, Video $video): JsonResponse
    {
        $like = $video->likes()->firstOrCreate(['user_id' => $request->user()->id]);

        if ($like->wasRecentlyCreated) {
            $video->increment('likes_count');
        }

        return response()->json([
            'liked' => true,
            'likes_count' => $video->refresh()->likes_count,
        ]);
    }

    public function destroy(Request $request, Video $video): JsonResponse
    {
        $deleted = $video->likes()->where('user_id', $request->user()->id)->delete();

        if ($deleted) {
            $video->decrement('likes_count');
        }

        return response()->json([
            'liked' => false,
            'likes_count' => $video->refresh()->likes_count,
        ]);
    }
}
