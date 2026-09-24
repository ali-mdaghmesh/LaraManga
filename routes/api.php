<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\LocalMangaController;
use App\Http\Controllers\MangaDexController;
use App\Http\Controllers\MangaTagController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TagController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);

Route::get('mangas/{manga}/tags', [MangaTagController::class, 'index']);

Route::get('chapters', [ChapterController::class, 'index']);
Route::get('chapters/{chapter}', [ChapterController::class, 'show']);

Route::get('chapters/mangadex/{mangadexId}', [ChapterController::class, 'mangadexChaptersWithLocal']);


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [LogoutController::class, 'logout']); 
    Route::post('/profile', [ProfileController::class, 'update']);

    Route::post('/like/toggle', [LikeController::class, 'toggle']); 

    Route::post('/favorites/toggle', [FavoriteController::class, 'toggle']);
    Route::get('/favorites', [FavoriteController::class, 'getFavorites']); 
});

Route::middleware(['auth:sanctum','check.role:admin'])->prefix('admin')->group(function () {

    Route::post('local-mangas/{localManga}', [LocalMangaController::class, 'update']); 
    Route::apiResource('local-mangas', LocalMangaController::class);
    Route::apiResource('tags', TagController::class);

    Route::post('mangas/{manga}/tags', [MangaTagController::class, 'store']);
    Route::put('mangas/{manga}/tags', [MangaTagController::class, 'update']);
    Route::delete('mangas/{manga}/tags/{tag}', [MangaTagController::class, 'destroy']);

    Route::post('chapters/bulk', [ChapterController::class, 'storeBulk']);
    Route::post('chapters/{chapter}', [ChapterController::class, 'update']);
    Route::delete('chapters/{chapter}', [ChapterController::class, 'destroy']);
});


Route::prefix('mangadex')->group(function () {
    Route::get('search', [MangaDexController::class, 'search']);
    Route::get('manga/{mangadexId}', [MangaDexController::class, 'show']);
   // Route::get('manga/{mangadexId}/chapters', [MangaDexController::class, 'chapters']);
    Route::get('chapter/{chapterId}/pages', [MangaDexController::class, 'chapterPages']);
});


