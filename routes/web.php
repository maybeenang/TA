<?php

use App\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::group(
    [
        'middleware' => ['auth', 'verified']
    ],
    function () {
        Route::get('/', fn() => view('pages.welcome'))->name('welcome');
        Route::get('/dashboard', [Controllers\DashboardController::class, 'index'])->name('dashboard');

        Route::get('/laporan', [Controllers\LaporanController::class, 'index'])->name('laporan');

        Route::get('/profile', [Controllers\ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [Controllers\ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');
    }
);

require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';
require __DIR__ . '/tenaga-pengajar.php';
