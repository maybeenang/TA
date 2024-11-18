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
        Route::get('laporan/{laporan}/print', [\App\Http\Controllers\TenagaPengajar\LaporanController::class, 'print'])->name('laporan.print');
        Route::get('laporan/{laporan}/pdf', [\App\Http\Controllers\TenagaPengajar\LaporanController::class, 'pdf'])->name('laporan.pdf');

        Route::resource('laporan', \App\Http\Controllers\TenagaPengajar\LaporanController::class);

        ROute::resource('cpmk', \App\Http\Controllers\TenagaPengajar\CpmkController::class);

        Route::resource('kelas', \App\Http\Controllers\TenagaPengajar\KelasController::class)
            ->parameters(['kelas' => 'kelas']);
    }
);
