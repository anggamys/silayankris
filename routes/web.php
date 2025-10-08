<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.guest.home');
})->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('pages.admin.dashboard');
    })->name('dashboard');
});

require __DIR__ . '/auth.php';
