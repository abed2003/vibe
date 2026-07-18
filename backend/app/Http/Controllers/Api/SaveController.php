<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SaveController extends Controller
{
    /**
     * Idempotent bookmark toggle, mirroring LikeController.
     */
    public function store(Request $request, Video $video): JsonResponse
    {
        $video->saves()->firstOrCreate(['user_id' => $request->user()->id]);

        return response()->json(['saved' => true]);
    }

    public function destroy(Request $request, Video $video): JsonResponse
    {
        $video->saves()->where('user_id', $request->user()->id)->delete();

        return response()->json(['saved' => false]);
    }
}
