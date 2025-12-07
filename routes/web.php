<?php

use App\Http\Controllers\Admin\BeritaController;
use App\Http\Controllers\Admin\Periodik\PerBulanController;
use App\Http\Controllers\Admin\Periodik\PerSemesterController;
use App\Http\Controllers\Admin\Periodik\PerTahunController;
use App\Http\Controllers\Admin\GerejaController;
use App\Http\Controllers\Admin\LokasiController;
use App\Http\Controllers\Admin\SekolahController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\User\Periodik\PerBulanUserController;
use App\Http\Controllers\User\Periodik\PerSemesterUserController;
use Illuminate\Support\Facades\Route;

// Guest routes
Route::get('/', function () {
    return view('pages.guest.home');
})->name('landingpage');
Route::get('/layanan', function () {
    return view('pages.guest.layanan');
})->name('layanan');
Route::get('/home', function () {
    return view('pages.guest.home');
})->name('home');
;

// Public routes for Berita
Route::get('/berita', [BeritaController::class, 'publicIndex'])->name('berita.index');
Route::get('/berita/{berita:slug}', [BeritaController::class, 'publicShow'])->name('berita.show');

// Resourceful routes for admin (requires auth)
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->as('admin.')
    ->group(function () {

        // Dashboard route
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        // Resourceful routes for admin entities
        Route::resource('users', UserController::class)->names('users');
        // Berita routes
        Route::resource('berita', BeritaController::class)->parameters([
            'berita' => 'berita'
        ])->names('berita');

        // Sekolah routes
        Route::resource('sekolah', SekolahController::class)->names('sekolah');

        // Periodik routes
        Route::resource('per-bulan', PerBulanController::class)->names('per-bulan');
        Route::resource('per-semester', PerSemesterController::class)->names('per-semester');
        Route::resource('per-tahun', PerTahunController::class)->names('per-tahun');

        // Gereja routes
        Route::resource('gereja', GerejaController::class)->names('gereja');

        Route::get('/get-kecamatan', [LokasiController::class, 'getKecamatan'])->name('lokasi.kecamatan');
        Route::get('/get-kelurahan', [LokasiController::class, 'getKelurahan'])->name('lokasi.kelurahan');
    });

    // Resourceful routes for PerBulan for users
Route::middleware(['auth', 'role:guru'])
    ->prefix('user/perbulan')
    ->as('user.perbulan.')
    ->group(function () {

        Route::get('/', [PerBulanUserController::class, 'index'])->name('index');
        Route::get('/create', [PerBulanUserController::class, 'create'])->name('create');
        Route::post('/', [PerBulanUserController::class, 'store'])->name('store');
        Route::get('/{perBulan}', [PerBulanUserController::class, 'show'])->name('show');
        // Allow users to edit their incomplete submissions and submit revisions
        Route::get('/{perBulan}/edit', [PerBulanUserController::class, 'edit'])->name('edit');
        Route::match(['put', 'patch'], '/{perBulan}', [PerBulanUserController::class, 'update'])->name('update');
    });



// Resourceful routes for PerSemester for users
Route::middleware(['auth', 'role:guru'])
    ->prefix('user/persemester')
    ->as('user.persemester.')
    ->group(function () {   
        Route::get('/', [PerSemesterUserController::class, 'index'])->name('index');
        Route::get('/create', [PerSemesterUserController::class, 'create'])->name('create');
        Route::post('/', [PerSemesterUserController::class, 'store'])->name('store');
        Route::get('/{perSemester}', [PerSemesterUserController::class, 'show'])->name('show');
        // Allow users to edit their incomplete submissions and submit revisions
        Route::get('/{perSemester}/edit', [PerSemesterUserController::class, 'edit'])->name('edit');
        Route::match(['put', 'patch'], '/{perSemester}', [PerSemesterUserController::class, 'update'])->name('update');
    });


// Resourceful routes for Pendataan Gereja for users
    Route::middleware(['auth', 'role:staff-gereja'])
    ->prefix('user')
    ->as('user.')
    ->group(function () {
        Route::get('/pendataan-gereja', [GerejaController::class, 'indexUser'])->name('gereja.index');
        Route::put('/pendataan-gereja/{gereja}', [GerejaController::class, 'updateUser'])->name('gereja.update');
    });

require __DIR__ . '/auth.php';
require __DIR__ . '/gdrive.php';