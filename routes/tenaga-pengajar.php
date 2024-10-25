<?php

use Illuminate\Support\Facades\Route;

Route::group(
    [
        'prefix' => 'tenaga-pengajar',
        'as' => 'tenaga-pengajar.',
        'middleware' => ['auth'],
    ],
    function () {
        /*Route::resource('user', \App\Http\Controllers\Admin\UserController::class);*/
        /*Route::resource('tenaga-pengajar', \App\Http\Controllers\Admin\TenagaPengajarController::class);*/
        Route::resource('mata-kuliah', \App\Http\Controllers\TenagaPengajar\MataKuliahController::class);
        Route::resource('kelas', \App\Http\Controllers\TenagaPengajar\KelasController::class);
        /*Route::resource('tahun-akademik', \App\Http\Controllers\Admin\TahunAkademikController::class);*/
    }
);
