<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\PostController as PublicPostController;
use App\Http\Controllers\Public\LiturgyController as PublicLiturgyController;
use App\Http\Controllers\Public\HistoryController as PublicHistoryController;
use App\Http\Controllers\Public\ContactController as PublicContactController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\LiturgyController as AdminLiturgyController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\MediaController as AdminMediaController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;


Route::get('/', HomeController::class);
Route::get('/warta', [PublicPostController::class, 'index']);
Route::get('/warta/{slug}', [PublicPostController::class, 'show']);
Route::get('/liturgi', PublicLiturgyController::class);
Route::get('/sejarah', PublicHistoryController::class);
Route::get('/kontak', [PublicContactController::class, 'index']);
Route::post('/kontak', [PublicContactController::class, 'submit'])->name('kontak.submit');


Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    
    Route::get('/', DashboardController::class)->name('dashboard');

    
    Route::resource('berita', AdminPostController::class)->parameters(['berita' => 'post'])->except(['show']);

    
    Route::resource('liturgi', AdminLiturgyController::class)->except(['show', 'create', 'edit']);

    
    Route::resource('kategori', AdminCategoryController::class)->except(['show', 'create', 'edit']);

    
    Route::resource('media', AdminMediaController::class)->parameters(['media' => 'media'])->except(['show', 'create', 'edit']);

    
    Route::resource('users', AdminUserController::class)->except(['show', 'create', 'edit']);
    Route::post('users/{user}/reset-password', [AdminUserController::class, 'resetPassword'])->name('users.reset-password');

    
    Route::get('settings', [AdminSettingController::class, 'index'])->name('settings.index');
    Route::post('settings', [AdminSettingController::class, 'update'])->name('settings.update');
    
    
    Route::post('settings/timeline', [AdminSettingController::class, 'storeTimeline'])->name('settings.timeline.store');
    Route::put('settings/timeline/{timeline}', [AdminSettingController::class, 'updateTimeline'])->name('settings.timeline.update');
    Route::delete('settings/timeline/{timeline}', [AdminSettingController::class, 'destroyTimeline'])->name('settings.timeline.destroy');
});
