<?php

use Illuminate\Support\Facades\Route;

Route::group(
    [
        'prefix' => 'admin',
        'as' => 'admin.',
        'middleware' => ['auth'],
    ],
    function () {
        Route::resource('tenaga-pengajar', \App\Http\Controllers\Admin\TenagaPengajarController::class);
        Route::resource('mata-kuliah', \App\Http\Controllers\Admin\MataKuliahController::class);
        Route::resource('kelas', \App\Http\Controllers\Admin\KelasController::class);
        Route::resource('tahun-akademik', \App\Http\Controllers\Admin\TahunAkademikController::class);
    }
);
