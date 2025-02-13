<?php

use App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;



Route::group(
    [
        'middleware' => ['auth', 'verified']
    ],
    function () {
        Route::get('/', [Controllers\DashboardController::class, 'welcome'])->name('welcome');
        Route::get('/dashboard', [Controllers\DashboardController::class, 'index'])->name('dashboard');

        Route::get('laporan/{laporan}/print', [\App\Http\Controllers\PDFController::class, 'print'])->name('laporan.print');
        Route::get('laporan/{laporan}/pdf', [\App\Http\Controllers\PDFController::class, 'pdf'])->name('laporan.pdf');

        Route::get('export-mhs/{kelas}', [\App\Http\Controllers\Admin\ImportExportController::class, 'exportMahasiswaKelas'])->name('export-mhs');
        Route::post('import-mhs/{kelas}', [\App\Http\Controllers\Admin\ImportExportController::class, 'importMahasiswaKelas'])->name('import-mhs');
    }
);

Route::group(
    [
        'middleware' => ['auth']
    ],
    function () {
        Route::get('/profile', [Controllers\ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [Controllers\ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');
        Route::post('/profile/update_photo', [Controllers\ProfileController::class, 'updatePhoto'])->name('profile.updatePhoto');
    }
);

Route::group(
    [
        'middleware' => ['auth', 'verified', 'role:admin|kaprodi|gkmp']
    ],
    function () {
        Route::resource('signature', \App\Http\Controllers\SignatureController::class);
    }
);

Route::group(
    [
        'middleware' => ['auth', 'verified', 'role:kaprodi|gkmp']
    ],
    function () {
        Route::get('transfer-role', [\App\Http\Controllers\TransferRole::class, 'index'])->name('transfer-role.index');
        Route::put('transfer-role', [\App\Http\Controllers\TransferRole::class, 'update'])->name('transfer-role.update');
    }
);

require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';
require __DIR__ . '/super-admin.php';
require __DIR__ . '/tenaga-pengajar.php';
require __DIR__ . '/kaprodi.php';
require __DIR__ . '/gkmp.php';
