<?php

namespace App\Enums;

use App\Exports\FakultasExport;
use App\Exports\KelasExport;
use App\Exports\MahasiswaExport;
use App\Exports\MatakuliahExport;
use App\Exports\ProdiExport;
use App\Exports\UsersExport;
use App\Imports\FakultasImport;
use App\Imports\KelasImport;
use App\Imports\MahasiswaImport;
use App\Imports\MatakuliahImport;
use App\Imports\ProdiImport;
use App\Imports\UsersImport;

enum ExportEnum: string
{
    case PENGGUNA = 'pengguna';
    case MAHASISWA = 'mahasiswa';
    case MATAKULIAH = 'matakuliah';
    case KELAS = 'kelas';
    case FAKULTAS = 'fakultas';
    case PRODI = 'prodi';

    // function melakukan export data sesuai dengan tipe yang dipilih
    public function exportData()
    {
        return match ($this) {
            static::PENGGUNA => (new UsersExport)->download('pengguna.xlsx'),
            static::MATAKULIAH => (new MatakuliahExport)->download('matakuliah.xlsx'),
            static::MAHASISWA => (new MahasiswaExport)->download('mahasiswa.xlsx'),
            static::KELAS => (new KelasExport)->download('kelas.xlsx'),
            static::FAKULTAS => (new FakultasExport)->download('fakultas.xlsx'),
            static::PRODI => (new ProdiExport)->download('prodi.xlsx'),
            default => null,
        };
    }

    public function importData($file)
    {
        return match ($this) {
            static::PENGGUNA => (new UsersImport)->import($file),
            static::MATAKULIAH => (new MatakuliahImport)->import($file),
            static::MAHASISWA => (new MahasiswaImport)->import($file),
            static::KELAS => (new KelasImport)->import($file),
            static::FAKULTAS => (new FakultasImport)->import($file),
            static::PRODI => (new ProdiImport)->import($file),
            default => null,
        };
    }
}
