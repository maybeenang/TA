<?php

namespace App\Enums;

use App\Exports\FakultasExport;
use App\Exports\KelasExport;
use App\Exports\MahasiswaExport;
use App\Exports\MatakuliahExport;
use App\Exports\ProdiExport;
use App\Exports\SuperAdminKelasExport;
use App\Exports\SuperAdminMahasiswaExport;
use App\Exports\SuperAdminMatakuliahExport;
use App\Exports\SuperAdminPenggunaExport;
use App\Exports\SuperAdminTahunAkademikExport;
use App\Exports\UsersExport;
use App\Imports\FakultasImport;
use App\Imports\KelasImport;
use App\Imports\MahasiswaImport;
use App\Imports\MatakuliahImport;
use App\Imports\ProdiImport;
use App\Imports\SuperAdminKelasImport;
use App\Imports\SuperAdminMahasiswaImport;
use App\Imports\SuperAdminMatakuliahImport;
use App\Imports\SuperAdminPenggunaImport;
use App\Imports\SuperAdminTahunAkademikImport;
use App\Imports\UsersImport;

enum ExportEnum: string
{
    case PENGGUNA = 'pengguna';
    case MAHASISWA = 'mahasiswa';
    case MATAKULIAH = 'matakuliah';
    case KELAS = 'kelas';
    case FAKULTAS = 'fakultas';
    case PRODI = 'prodi';

    case SUPERADMINPENGGUNA = 'superadminpengguna';
    case SUPERADMINMAHASISWA = 'superadminmahasiswa';
    case SUPERADMINTAHUNAKADEMIK = 'superadmintahunakademik';
    case SUPERADMINKELAS = 'superadminkelas';
    case SUPERADMINMATAKULIAH = 'superadminmatakuliah';

    public function exportData()
    {
        return match ($this) {
            static::PENGGUNA => (new UsersExport)->download('pengguna.xlsx'),
            static::MATAKULIAH => (new MatakuliahExport)->download('matakuliah.xlsx'),
            static::MAHASISWA => (new MahasiswaExport)->download('mahasiswa.xlsx'),
            static::KELAS => (new KelasExport)->download('kelas.xlsx'),
            static::FAKULTAS => (new FakultasExport)->download('fakultas.xlsx'),
            static::PRODI => (new ProdiExport)->download('prodi.xlsx'),
            static::SUPERADMINPENGGUNA => (new SuperAdminPenggunaExport)->download('super-admin-pengguna.xlsx'),
            static::SUPERADMINMAHASISWA => (new SuperAdminMahasiswaExport)->download('super-admin-mahasiswa.xlsx'),
            static::SUPERADMINTAHUNAKADEMIK => (new SuperAdminTahunAkademikExport)->download('super-admin-tahun-akademik.xlsx'),
            static::SUPERADMINKELAS => (new SuperAdminKelasExport)->download('super-admin-kelas.xlsx'),
            static::SUPERADMINMATAKULIAH => (new SuperAdminMatakuliahExport)->download('super-admin-matakuliah.xlsx'),
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
            static::SUPERADMINPENGGUNA => (new SuperAdminPenggunaImport)->import($file),
            static::SUPERADMINMAHASISWA => (new SuperAdminMahasiswaImport)->import($file),
            static::SUPERADMINTAHUNAKADEMIK => (new SuperAdminTahunAkademikImport)->import($file),
            static::SUPERADMINKELAS => (new SuperAdminKelasImport)->import($file),
            static::SUPERADMINMATAKULIAH => (new SuperAdminMatakuliahImport)->import($file),
            default => null,
        };
    }
}
