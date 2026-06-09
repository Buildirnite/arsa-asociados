<?php

use App\Http\Controllers\Admin\AppointmentAdminController;
use App\Http\Controllers\Admin\ContactMessageAdminController;
use App\Http\Controllers\Admin\PostAdminController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PracticeAreaController;
use App\Http\Middleware\AdminPassword;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/contacto', [ContactController::class, 'store'])->name('contact.store')->middleware('throttle:3,1');

Route::get('/agendar', [AppointmentController::class, 'create'])->name('agendar.create');
Route::get('/agendar/horarios', [AppointmentController::class, 'slots'])->name('agendar.slots');
Route::get('/agendar/listo', [AppointmentController::class, 'confirmation'])->name('agendar.confirmacion');
Route::post('/agendar', [AppointmentController::class, 'store'])->name('agendar.store')->middleware('throttle:5,1');

Route::get('/sitemap.xml', function () {
    $posts = \App\Models\Post::published()->orderByDesc('updated_at')->get();
    return response()->view('sitemap', compact('posts'))
        ->header('Content-Type', 'application/xml');
});

Route::get('/servicios/{slug}', [PracticeAreaController::class, 'show'])->name('services.show');

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
    Route::delete('mensajes/{message}', [ContactMessageAdminController::class, 'destroy'])->name('mensajes.destroy');

    // Citas — rutas específicas antes de las parametrizadas.
    Route::get('citas', [AppointmentAdminController::class, 'index'])->name('citas.index');
    Route::get('citas/crear', [AppointmentAdminController::class, 'create'])->name('citas.create');
    Route::post('citas', [AppointmentAdminController::class, 'store'])->name('citas.store');
    Route::get('citas/{appointment}/editar', [AppointmentAdminController::class, 'edit'])->name('citas.edit');
    Route::patch('citas/{appointment}', [AppointmentAdminController::class, 'updateStatus'])->name('citas.updateStatus');
    Route::put('citas/{appointment}', [AppointmentAdminController::class, 'update'])->name('citas.update');
    Route::delete('citas/{appointment}', [AppointmentAdminController::class, 'destroy'])->name('citas.destroy');
});
