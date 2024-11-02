<?php

use Illuminate\Support\Facades\Route;

Route::group(
    [
        'prefix' => 'tenaga-pengajar',
        'as' => 'tenaga-pengajar.',
        'middleware' => ['auth'],
    ],
    function () {
        Route::get('laporan/select', [\App\Http\Controllers\TenagaPengajar\LaporanController::class, 'select'])->name('laporan.select');
        Route::resource('laporan', \App\Http\Controllers\TenagaPengajar\LaporanController::class);

        Route::resource('kelas', \App\Http\Controllers\TenagaPengajar\KelasController::class);
    }
);
