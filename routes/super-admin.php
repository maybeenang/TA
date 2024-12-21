<?php

use Illuminate\Support\Facades\Route;

Route::group(
    [
        'prefix' => 'super-admin',
        'as' => 'super-admin.',
        'middleware' => [
            'auth',
            'role:super-admin'
        ],
    ],
    function () {
        Route::get('/master-data', [\App\Http\Controllers\SuperAdmin\MasterDataController::class, 'index'])->name('master-data.index');

        Route::prefix('master-data')->group(
            function () {
                Route::resource('tahun-akademik', \App\Http\Controllers\SuperAdmin\TahunAkademikController::class)->parameter('tahun-akademik', 'academicYear');
                Route::resource('program-studi', \App\Http\Controllers\SuperAdmin\ProgramStudiController::class);
                Route::resource('mata-kuliah', \App\Http\Controllers\SuperAdmin\MataKuliahController::class)->parameter('mata-kuliah', 'course');
                Route::resource('kelas', \App\Http\Controllers\SuperAdmin\KelasController::class)->parameter('kelas', 'classRoom');
            }
        );
    }
);
