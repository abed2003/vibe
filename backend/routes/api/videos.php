<?php

use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\LikeController;
use App\Http\Controllers\Api\SaveController;
use App\Http\Controllers\Api\VideoController;
use Illuminate\Support\Facades\Route;

// Named "api.videos.*" (not "videos.*") deliberately: routes/web.php already
// defines a "videos.show" route for the SPA catch-all, and route names must
// be unique across the whole app.
Route::middleware('throttle:api')->name('api.videos.')->prefix('videos')->group(function () {
    Route::get('/', [VideoController::class, 'index'])->name('index');
    Route::get('/{video:uuid}', [VideoController::class, 'show'])->name('show');
    Route::get('/{video:uuid}/comments', [CommentController::class, 'index'])->name('comments.index');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/', [VideoController::class, 'store'])
            ->middleware('throttle:video-uploads')
            ->name('store');
        Route::delete('/{video:uuid}', [VideoController::class, 'destroy'])->name('destroy');

        Route::post('/{video:uuid}/likes', [LikeController::class, 'store'])->name('likes.store');
        Route::delete('/{video:uuid}/likes', [LikeController::class, 'destroy'])->name('likes.destroy');
        Route::post('/{video:uuid}/saves', [SaveController::class, 'store'])->name('saves.store');
        Route::delete('/{video:uuid}/saves', [SaveController::class, 'destroy'])->name('saves.destroy');
        Route::post('/{video:uuid}/comments', [CommentController::class, 'store'])->name('comments.store');
    });
});

Route::middleware(['auth:sanctum', 'throttle:api'])->name('api.comments.')->group(function () {
    Route::delete('comments/{comment:uuid}', [CommentController::class, 'destroy'])->name('destroy');
});
