<?php

use App\Http\Controllers\Api\VideoController;
use Illuminate\Support\Facades\Route;

// Named "api.videos.*" (not "videos.*") deliberately: routes/web.php already
// defines a "videos.show" route for the SPA catch-all, and route names must
// be unique across the whole app.
Route::middleware('throttle:api')->name('api.videos.')->prefix('videos')->group(function () {
    Route::get('/', [VideoController::class, 'index'])->name('index');
    Route::get('/{video:uuid}', [VideoController::class, 'show'])->name('show');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/', [VideoController::class, 'store'])
            ->middleware('throttle:video-uploads')
            ->name('store');
        Route::delete('/{video:uuid}', [VideoController::class, 'destroy'])->name('destroy');
    });
});
