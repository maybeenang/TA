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
            }
        );
    }
);
