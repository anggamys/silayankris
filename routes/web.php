<?php

use App\Http\Controllers\InstituteController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.guest.home');
})->name('home');

Route::middleware(['auth'])->as('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('pages.admin.dashboard');
    })->name('dashboard');

    Route::resource('users', UserController::class)->names('users');

    Route::resource('institutes', InstituteController::class)->names('institutes');

});


require __DIR__ . '/auth.php';
