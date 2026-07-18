<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\VideoResource;
use App\Models\User;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserController extends Controller
{
    /**
     * A user's uploaded videos. Guests/other users only ever see the publicly
     * visible ones; the owner additionally sees pending/processing/failed and
     * private or unlisted uploads (needed by the studio/profile pages).
     */
    public function videos(Request $request, User $user): AnonymousResourceCollection
    {
        $viewer = $request->user();

        $query = Video::ownedBy($user)
            ->with('user')
            ->when($viewer, fn ($q) => $q->withExists([
                'likes as liked_by_me' => fn ($lq) => $lq->where('user_id', $viewer->id),
                'saves as saved_by_me' => fn ($sq) => $sq->where('user_id', $viewer->id),
            ]))
            ->when($viewer?->id !== $user->id, fn ($q) => $q->publiclyVisible())
            ->latest('created_at');

        return VideoResource::collection($query->cursorPaginate(15));
    }
}
