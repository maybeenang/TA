<?php

use App\Http\Controllers\Gkmp\LaporanController;

use Illuminate\Support\Facades\Route;


Route::group(
    [
        'prefix' => 'gkmp',
        'as' => 'gkmp.',
        'middleware' => [
            'auth',
            'role:gkmp'
        ],
    ],
    function () {

        Route::get('/laporan/{laporan}/verifikasi', [LaporanController::class, 'verifikasi'])->name('laporan.verifikasi.edit');
        Route::get('/laporan/verifikasi', [LaporanController::class, 'verifikasiLaporan'])->name('laporan.verifikasi');
        Route::get('/laporan/arsip', [LaporanController::class, 'arsipLaporan'])->name('laporan.arsip');

        Route::put('/laporan/{laporan}/verifikasi', [LaporanController::class, 'verifikasiLaporanUpdate'])->name('laporan.verifikasi.update');

        Route::resource('laporan', LaporanController::class);
    }
);
