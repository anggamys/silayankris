<?php

use App\Http\Controllers\BeritaController;
use App\Http\Controllers\GerejaController;
use App\Http\Controllers\SekolahController;
use App\Http\Controllers\UserController;
use App\Models\Gereja;
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


   Route::resource('berita', BeritaController::class)->parameters([
    'berita' => 'berita'
])->names('berita');

    Route::resource('sekolah', SekolahController::class)->names('sekolah');
    Route::resource('gereja', GerejaController::class)->names('gereja');
});




require __DIR__ . '/auth.php';
