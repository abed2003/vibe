<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Video;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class CommentController extends Controller
{
    /**
     * Cursor-paginated like the video feed: comment threads grow unbounded and
     * receive concurrent writes while being read.
     */
    public function index(Video $video): AnonymousResourceCollection
    {
        $comments = $video->comments()
            ->with('user')
            ->latest()
            ->cursorPaginate(15);

        return CommentResource::collection($comments);
    }

    public function store(StoreCommentRequest $request, Video $video): JsonResponse
    {
        $comment = $video->comments()->create([
            'user_id' => $request->user()->id,
            'body' => $request->validated('body'),
        ]);

        $video->increment('comments_count');

        return (new CommentResource($comment->load('user')))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function destroy(Request $request, Comment $comment): Response
    {
        $this->authorize('delete', $comment);

        $video = $comment->video;
        $comment->delete();

        if ($video) {
            $video->decrement('comments_count');
        }

        return response()->noContent();
    }
}
