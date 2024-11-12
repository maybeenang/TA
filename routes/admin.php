<?php

use Illuminate\Support\Facades\Route;

Route::group(
    [
        'prefix' => 'admin',
        'as' => 'admin.',
        'middleware' => [
            'auth',
            'role:admin'
        ],
    ],
    function () {
        Route::resource('user', \App\Http\Controllers\Admin\UserController::class);
        Route::resource('tenaga-pengajar', \App\Http\Controllers\Admin\TenagaPengajarController::class);
        Route::resource('mata-kuliah', \App\Http\Controllers\Admin\MataKuliahController::class);
        Route::resource('kelas', \App\Http\Controllers\Admin\KelasController::class)
            ->parameters(['kelas' => 'kelas']);

        Route::resource('tahun-akademik', \App\Http\Controllers\Admin\TahunAkademikController::class);
        Route::resource('laporan', \App\Http\Controllers\Admin\LaporanController::class);
    }
);
