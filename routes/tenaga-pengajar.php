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

        Route::patch('laporan/pengajuan-verifikasi/{laporan}', [\App\Http\Controllers\TenagaPengajar\LaporanController::class, 'pengajuanVerifikasi'])->name('laporan.pengajuanVerifikasi');

        Route::get('laporan/{laporan}/export-penilaian', [\App\Http\Controllers\TenagaPengajar\LaporanController::class, 'exportPenilaian'])->name('laporan.exportPenilaian');

        Route::put('laporan/{laporan}/import-penilaian', [\App\Http\Controllers\TenagaPengajar\LaporanController::class, 'importPenilaian'])->name('laporan.importPenilaian');

        Route::resource('laporan', \App\Http\Controllers\TenagaPengajar\LaporanController::class);

        Route::resource('cpmk', \App\Http\Controllers\TenagaPengajar\CpmkController::class);


        Route::get('kelas/tambah-mahasiswa/{kelas}', [\App\Http\Controllers\TenagaPengajar\KelasController::class, 'tambahMahasiswa'])->name('kelas.tambah-mahasiswa');
        Route::post('kelas/tambah-mahasiswa/{kelas}', [\App\Http\Controllers\TenagaPengajar\KelasController::class, 'storeMahasiswa'])->name('kelas.store-mahasiswa');

        Route::resource('kelas', \App\Http\Controllers\TenagaPengajar\KelasController::class)
            ->parameters(['kelas' => 'kelas']);
    }
);
