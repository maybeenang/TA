<?php

use Illuminate\Support\Facades\Route;

Route::group(
    [
        'prefix' => 'tenaga-pengajar',
        'as' => 'tenaga-pengajar.',
        'middleware' => [
            'auth',
            'role:tenaga-pengajar'
        ],
    ],
    function () {
        Route::get('laporan/select', [\App\Http\Controllers\TenagaPengajar\LaporanController::class, 'select'])->name('laporan.select');

        Route::resource('laporan', \App\Http\Controllers\TenagaPengajar\LaporanController::class);

        ROute::resource('cpmk', \App\Http\Controllers\TenagaPengajar\CpmkController::class);

        Route::resource('kelas', \App\Http\Controllers\TenagaPengajar\KelasController::class);
    }
);
