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
        Route::resource('mata-kuliah', \App\Http\Controllers\Admin\MataKuliahController::class)->parameters(['mata-kuliah' => 'mataKuliah']);

        Route::get('kelas/tambah-mahasiswa/{kelas}', [\App\Http\Controllers\Admin\KelasController::class, 'tambahMahasiswa'])->name('kelas.tambah-mahasiswa');
        Route::post('kelas/tambah-mahasiswa/{kelas}', [\App\Http\Controllers\Admin\KelasController::class, 'storeMahasiswa'])->name('kelas.store-mahasiswa');

        Route::resource('kelas', \App\Http\Controllers\Admin\KelasController::class)
            ->parameters(['kelas' => 'kelas']);

        Route::resource('tahun-akademik', \App\Http\Controllers\Admin\TahunAkademikController::class);

        Route::group(
            [
                'prefix' => 'master-data',
                'as' => 'master-data.',
            ],
            function () {
                Route::resource('/', \App\Http\Controllers\Admin\MasterdataController::class);
                Route::put('program-studi-update', [\App\Http\Controllers\Admin\MasterdataController::class, 'programStudiUpdate'])->name('program-studi.update');
                Route::get('export/{type}', [\App\Http\Controllers\Admin\MasterdataController::class, 'export'])->name('export');
                Route::post('import/{type}', [\App\Http\Controllers\Admin\MasterdataController::class, 'import'])->name('import');
                Route::post('sync/{type}', [\App\Http\Controllers\Admin\MasterdataController::class, 'sync'])->name('sync');
            }
        );



        Route::get('/laporan/verifikasi', [\App\Http\Controllers\Admin\LaporanController::class, 'verifikasiLaporan'])->name('laporan.verifikasi');
        Route::get('/laporan/arsip', [\App\Http\Controllers\Admin\LaporanController::class, 'arsipLaporan'])->name('laporan.arsip');
        Route::get('/laporan/{laporan}/verifikasi', [\App\Http\Controllers\Admin\LaporanController::class, 'verifikasiLaporanEdit'])->name('laporan.verifikasi.edit');
        Route::get('laporan/verifikasi/count', [\App\Http\Controllers\Admin\LaporanController::class, 'countVerifikasi'])->name('laporan.verifikasi.count');

        Route::put('/laporan/{laporan}/verifikasi', [\App\Http\Controllers\Admin\LaporanController::class, 'verifikasiLaporanUpdate'])->name('laporan.verifikasi.update');
        Route::resource('laporan', \App\Http\Controllers\Admin\LaporanController::class);

        Route::resource('student', \App\Http\Controllers\Admin\StudentController::class);
    }
);

Route::group([
    'prefix' => 'admin',
    'as' => 'admin.',
    'middleware' => [
        'auth',
        'role:admin|super-admin'
    ],
], function () {

    Route::get('export-template/{type}', [\App\Http\Controllers\Admin\ImportExportController::class, 'export'])->name('export-template');
    Route::post('import/{type}', [\App\Http\Controllers\Admin\ImportExportController::class, 'import'])->name('import');
});
