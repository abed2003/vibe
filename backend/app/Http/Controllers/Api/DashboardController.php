<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Enums\VideoStatus;
use App\Models\Comment;
use App\Models\Like;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Aggregate stats for the creator dashboard — computed live from the
     * database (the tables are all indexed for these lookups).
     */
    public function __invoke(Request $request): JsonResponse
    {
        $user = $request->user();
        $videos = $user->videos();

        return response()->json([
            'videos_total' => (clone $videos)->count(),
            'videos_published' => (clone $videos)->where('status', VideoStatus::Ready)->count(),
            'videos_processing' => (clone $videos)->whereIn('status', [VideoStatus::Pending, VideoStatus::Processing])->count(),
            'videos_failed' => (clone $videos)->where('status', VideoStatus::Failed)->count(),
            'total_views' => (int) (clone $videos)->sum('views_count'),
            'total_likes' => Like::whereIn('video_id', $user->videos()->select('id'))->count(),
            'total_comments' => Comment::whereIn('video_id', $user->videos()->select('id'))->count(),
            'followers_count' => $user->followers()->count(),
        ]);
    }
}
