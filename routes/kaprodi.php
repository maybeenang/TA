<?php

use App\Http\Controllers\Kaprodi\LaporanController;

use Illuminate\Support\Facades\Route;


Route::group(
    [
        'prefix' => 'kaprodi',
        'as' => 'kaprodi.',
        'middleware' => [
            'auth',
            'role:kaprodi'
        ],
    ],
    function () {

        Route::get('/laporan/{laporan}/verifikasi', [LaporanController::class, 'verifikasi'])->name('laporan.verifikasi.edit');
        Route::get('/laporan/arsip', [LaporanController::class, 'arsipLaporan'])->name('laporan.arsip');

        Route::put('/laporan/{laporan}/verifikasi', [LaporanController::class, 'verifikasiLaporanUpdate'])->name('laporan.verifikasi.update');

        Route::resource('laporan', LaporanController::class);
    }
);
