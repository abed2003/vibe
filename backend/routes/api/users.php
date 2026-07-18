<?php

use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\FollowController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('throttle:api')->name('api.')->group(function () {
    Route::get('users/{user}/videos', [UserController::class, 'videos'])->name('users.videos');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('users/{user}/follows', [FollowController::class, 'store'])->name('follows.store');
        Route::delete('users/{user}/follows', [FollowController::class, 'destroy'])->name('follows.destroy');
        Route::get('dashboard', DashboardController::class)->name('dashboard');
    });
});
