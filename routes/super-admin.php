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
                Route::post('scrape', [\App\Http\Controllers\SuperAdmin\ScrapeController::class, 'scrape'])->name('scrape');

                Route::resource('tahun-akademik', \App\Http\Controllers\SuperAdmin\TahunAkademikController::class)->parameter('tahun-akademik', 'academicYear');
                Route::get('program-studi/scrape-data', [\App\Http\Controllers\SuperAdmin\ProgramStudiController::class, 'scrapeData'])->name('program-studi.scrape-data');
                Route::resource('program-studi', \App\Http\Controllers\SuperAdmin\ProgramStudiController::class);

                Route::resource('mata-kuliah', \App\Http\Controllers\SuperAdmin\MataKuliahController::class)->parameter('mata-kuliah', 'course');

                Route::get('kelas/scrape-data/{classRoom}', [\App\Http\Controllers\SuperAdmin\KelasController::class, 'scrapeData'])->name('kelas.scrape-data');
                Route::resource('kelas', \App\Http\Controllers\SuperAdmin\KelasController::class)->parameter('kelas', 'classRoom');

                Route::resource('laporan', \App\Http\Controllers\SuperAdmin\LaporanController::class)->parameter('laporan', 'report');

                Route::resource('user', \App\Http\Controllers\SuperAdmin\UserController::class)->parameter('user', 'user');

                Route::resource('student', \App\Http\Controllers\SuperAdmin\StudentController::class)->parameter('student', 'student');

                Route::resource('fakultas', \App\Http\Controllers\SuperAdmin\FakultasController::class)->parameter('fakultas', 'fakultas');
            }
        );
    }
);
