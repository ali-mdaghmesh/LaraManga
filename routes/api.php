<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\LocalMangaController;
use App\Http\Controllers\MangaTagController;
use App\Http\Controllers\TagController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);

Route::get('mangas/{manga}/tags', [MangaTagController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [LogoutController::class, 'logout']); 
});

Route::middleware(['auth:sanctum','check.role:admin'])->prefix('admin')->group(function () {

    Route::apiResource('local-mangas', LocalMangaController::class);
    Route::apiResource('tags', TagController::class);

    Route::post('mangas/{manga}/tags', [MangaTagController::class, 'store']);
    Route::put('mangas/{manga}/tags', [MangaTagController::class, 'update']);
    Route::delete('mangas/{manga}/tags/{tag}', [MangaTagController::class, 'destroy']);
});



