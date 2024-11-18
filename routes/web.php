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

        Route::get('/profile', [Controllers\ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [Controllers\ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');

        Route::get('laporan/{laporan}/print', [\App\Http\Controllers\PDFController::class, 'print'])->name('laporan.print');
        Route::get('laporan/{laporan}/pdf', [\App\Http\Controllers\PDFController::class, 'pdf'])->name('laporan.pdf');
    }
);

require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';
require __DIR__ . '/tenaga-pengajar.php';
