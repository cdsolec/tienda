<?php

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\CommentController;

/*
|--------------------------------------------------------------------------
| Admin Routes of Users
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| Admin Routes of Settings
|--------------------------------------------------------------------------
*/
Route::get('/settings/trash', [SettingController::class, 'trash'])->name('settings.trash');
Route::get('/settings/{id}/restore', [SettingController::class, 'restore'])->name('settings.restore')
      ->where('id', '[0-9]+');
Route::patch('/settings/{id}/delete', [SettingController::class, 'delete'])->name('settings.delete')
      ->where('id', '[0-9]+');
Route::resource('settings', SettingController::class);

/*
|--------------------------------------------------------------------------
| Admin Routes of Banners
|--------------------------------------------------------------------------
*/
Route::get('/banners/trash', [BannerController::class, 'trash'])->name('banners.trash');
Route::get('/banners/{id}/restore', [BannerController::class, 'restore'])->name('banners.restore')
      ->where('id', '[0-9]+');
Route::patch('/banners/{id}/delete', [BannerController::class, 'delete'])->name('banners.delete')
      ->where('id', '[0-9]+');
Route::resource('banners', BannerController::class);

/*
|--------------------------------------------------------------------------
| Admin Routes of Contents
|--------------------------------------------------------------------------
*/
Route::get('/contents/trash', [ContentController::class, 'trash'])->name('contents.trash');
Route::get('/contents/{id}/restore', [ContentController::class, 'restore'])->name('contents.restore')
      ->where('id', '[0-9]+');
Route::patch('/contents/{id}/delete', [ContentController::class, 'delete'])->name('contents.delete')
      ->where('id', '[0-9]+');
Route::resource('contents', ContentController::class);

/*
|--------------------------------------------------------------------------
| Admin Routes of Comments
|--------------------------------------------------------------------------
*/
Route::get('/comments/trash', [CommentController::class, 'trash'])->name('comments.trash');
Route::get('/comments/{id}/restore', [CommentController::class, 'restore'])->name('comments.restore')
      ->where('id', '[0-9]+');
Route::patch('/comments/{id}/delete', [CommentController::class, 'delete'])->name('comments.delete')
      ->where('id', '[0-9]+');
Route::resource('comments', CommentController::class)->only([
      'index', 'edit', 'update', 'destroy'
]);
