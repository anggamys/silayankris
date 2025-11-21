<?php

use App\Http\Controllers\Admin\BeritaController;
use App\Http\Controllers\Admin\Periodik\PerBulanController;
use App\Http\Controllers\Admin\GerejaController;
use App\Http\Controllers\Admin\LokasiController;
use App\Http\Controllers\Admin\SekolahController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.guest.home');
})->name('landingpage');
Route::get('/layanan', function () {
    return view('pages.guest.layanan');
})->name('layanan');
Route::get('/home', function () {
    return view('pages.guest.home');
})->name('home');;


Route::get('/berita', [BeritaController::class, 'publicIndex'])->name('berita.index');
Route::get('/berita/{berita:slug}', [BeritaController::class, 'publicShow'])->name('berita.show');

Route::middleware(['auth'])
    ->prefix('admin')
    ->as('admin.')
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('pages.admin.dashboard');
        })->name('dashboard');

        Route::resource('users', UserController::class)->names('users');

        Route::resource('berita', BeritaController::class)->parameters([
            'berita' => 'berita'
        ])->names('berita');

        Route::resource('sekolah', SekolahController::class)->names('sekolah');

        Route::resource('per-bulan', PerBulanController::class)->names('per-bulan');
        Route::resource('per-semester', PerBulanController::class)->names('per-semester');
        Route::resource('per-tahun', PerBulanController::class)->names('per-tahun');

        Route::resource('gereja', GerejaController::class)->names('gereja');

        Route::get('/get-kecamatan', [LokasiController::class, 'getKecamatan'])->name('lokasi.kecamatan');
        Route::get('/get-kelurahan', [LokasiController::class, 'getKelurahan'])->name('lokasi.kelurahan');
    });

require __DIR__ . '/auth.php';
require __DIR__ . '/gdrive.php';
