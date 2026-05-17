<?php

use App\Http\Controllers\Admin\ContactMessageAdminController;
use App\Http\Controllers\Admin\PostAdminController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PostController;
use App\Http\Middleware\AdminPassword;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/contacto', [ContactController::class, 'store'])->name('contact.store')->middleware('throttle:3,1');

Route::get('/sitemap.xml', function () {
    $posts = \App\Models\Post::published()->orderByDesc('updated_at')->get();
    return response()->view('sitemap', compact('posts'))
        ->header('Content-Type', 'application/xml');
});

Route::get('/politica-de-privacidad', fn () => view('legal.privacy'))->name('legal.privacy');
Route::get('/terminos-de-uso', fn () => view('legal.terms'))->name('legal.terms');

Route::prefix('blog')->name('blog.')->group(function () {
    Route::get('/', [PostController::class, 'index'])->name('index');
    Route::get('/{slug}', [PostController::class, 'show'])->name('show');
});

Route::prefix('admin')->name('admin.')->middleware(AdminPassword::class)->group(function () {
    Route::get('/', fn () => redirect()->route('admin.posts.index'));
    Route::post('/', fn () => redirect()->route('admin.posts.index'));
    Route::post('upload-image', [PostAdminController::class, 'uploadImage'])->name('posts.upload-image');
    Route::get('posts/export', [PostAdminController::class, 'export'])->name('posts.export');
    Route::delete('posts/{post}/image', [PostAdminController::class, 'destroyImage'])->name('posts.destroyImage');
    Route::get('posts/{post}/preview', [PostAdminController::class, 'preview'])->name('posts.preview');
    Route::resource('posts', PostAdminController::class);
    Route::get('mensajes', [ContactMessageAdminController::class, 'index'])->name('mensajes.index');
    Route::patch('mensajes/{message}/leer', [ContactMessageAdminController::class, 'markRead'])->name('mensajes.markRead');
});
