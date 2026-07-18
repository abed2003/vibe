<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class FollowController extends Controller
{
    /**
     * Idempotent follow toggle, mirroring LikeController.
     */
    public function store(Request $request, User $user): JsonResponse
    {
        if ($request->user()->id === $user->id) {
            throw ValidationException::withMessages([
                'user' => ['You cannot follow yourself.'],
            ]);
        }

        $user->followers()->firstOrCreate(['follower_id' => $request->user()->id]);

        return response()->json([
            'following' => true,
            'followers_count' => $user->followers()->count(),
        ]);
    }

    public function destroy(Request $request, User $user): JsonResponse
    {
        $user->followers()->where('follower_id', $request->user()->id)->delete();

        return response()->json([
            'following' => false,
            'followers_count' => $user->followers()->count(),
        ]);
    }
}
