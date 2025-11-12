<?php

use App\Http\Controllers\BeritaController;
use App\Http\Controllers\InstituteController;
use App\Http\Controllers\SekolahController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

use function Pest\Laravel\be;

Route::get('/', function () {
    return view('pages.guest.home');
})->name('home');

Route::middleware(['auth'])->as('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('pages.admin.dashboard');
    })->name('dashboard');

    Route::resource('users', UserController::class)->names('users');

    Route::resource('institutes', InstituteController::class)->names('institutes');


   Route::resource('berita', BeritaController::class)->parameters([
    'berita' => 'berita'
])->names('berita');

    Route::resource('sekolah', SekolahController::class)->names('sekolah');
});


require __DIR__ . '/auth.php';
