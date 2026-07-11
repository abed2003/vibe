<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'app')->name('welcome');
Route::view('/splash', 'app')->name('splash');
Route::view('/login', 'app')->name('login');
Route::view('/register', 'app')->name('register');
Route::view('/feed', 'app')->name('feed');
Route::view('/explore', 'app')->name('explore');
Route::view('/search', 'app')->name('search');
Route::view('/messages', 'app')->name('messages');
Route::view('/contact', 'app')->name('contact');
Route::view('/videos/{video?}', 'app')->name('videos.show');
