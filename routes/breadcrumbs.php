<?php // routes/breadcrumbs.php

use App\Models\User;
use Diglactic\Breadcrumbs\Breadcrumbs;

use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

Breadcrumbs::for('welcome', function (BreadcrumbTrail $trail) {
    $trail->push('Beranda', route('welcome'));
});

Breadcrumbs::for('laporan', function (BreadcrumbTrail $trail) {
    $trail->parent('welcome');
    $trail->push('Laporan', route('laporan'));
});

Breadcrumbs::for('admin.tenaga-pengajar.index', function (BreadcrumbTrail $trail) {
    $trail->parent('welcome');
    $trail->push('Tenaga Pengajar', route('admin.tenaga-pengajar.index'));
});

Breadcrumbs::for('admin.master-data.index', function (BreadcrumbTrail $trail) {
    $trail->parent('welcome');
    $trail->push('Pengaturan', route('admin.master-data.index'));
});

Breadcrumbs::for('admin.tenaga-pengajar.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.tenaga-pengajar.index');
    $trail->push('Tambah Tenaga Pengajar', route('admin.tenaga-pengajar.create'));
});

Breadcrumbs::for('admin.mata-kuliah.index', function (BreadcrumbTrail $trail) {
    $trail->parent('welcome');
    $trail->push('Mata Kuliah', route('admin.mata-kuliah.index'));
});

Breadcrumbs::for('admin.mata-kuliah.edit', function (BreadcrumbTrail $trail, $mataKuliah) {
    $trail->parent('admin.mata-kuliah.index');
    $trail->push('Edit Mata Kuliah', route('admin.mata-kuliah.edit', $mataKuliah));
});

Breadcrumbs::for('admin.mata-kuliah.show', function (BreadcrumbTrail $trail, $mataKuliah) {
    $trail->parent('admin.mata-kuliah.index');
    $trail->push($mataKuliah->name, route('admin.mata-kuliah.show', $mataKuliah));
});

Breadcrumbs::for('admin.mata-kuliah.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.mata-kuliah.index');
    $trail->push('Tambah Mata Kuliah', route('admin.mata-kuliah.create'));
});

Breadcrumbs::for('admin.tahun-akademik.index', function (BreadcrumbTrail $trail) {
    $trail->parent('welcome');
    $trail->push('Tahun Akademik', route('admin.tahun-akademik.index'));
});

Breadcrumbs::for('admin.tahun-akademik.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.tahun-akademik.index');
    $trail->push('Tambah Tahun Akademik', route('admin.tahun-akademik.create'));
});

Breadcrumbs::for('admin.kelas.index', function (BreadcrumbTrail $trail) {
    $trail->parent('welcome');
    $trail->push('Kelas', route('admin.kelas.index'));
});

Breadcrumbs::for('admin.kelas.show', function (BreadcrumbTrail $trail, $kelas) {
    $trail->parent('admin.kelas.index');
    $trail->push($kelas->fullName, route('admin.kelas.show', $kelas));
});

Breadcrumbs::for('admin.kelas.edit', function (BreadcrumbTrail $trail, $kelas) {
    $trail->parent('admin.kelas.index');
    $trail->push('Edit Kelas', route('admin.kelas.edit', $kelas));
});

Breadcrumbs::for('admin.kelas.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.kelas.index');
    $trail->push('Tambah Kelas', route('admin.kelas.create'));
});

Breadcrumbs::for('admin.user.index', function (BreadcrumbTrail $trail) {
    $trail->parent('welcome');
    $trail->push('Pengguna', route('admin.user.index'));
});

Breadcrumbs::for('admin.user.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.user.index');
    $trail->push('Tambah Pengguna', route('admin.user.create'));
});

Breadcrumbs::for('admin.user.show', function (BreadcrumbTrail $trail, User $user) {
    $trail->parent('admin.user.index');
    $trail->push('Detail Pengguna', route('admin.user.show', $user));
});

Breadcrumbs::for('admin.user.edit', function (BreadcrumbTrail $trail, User $user) {
    $trail->parent('admin.user.index');
    $trail->push('Edit Informasi Pengguna', route('admin.user.edit', $user));
});

Breadcrumbs::for('admin.laporan.index', function (BreadcrumbTrail $trail) {
    $trail->parent('welcome');
    $trail->push('Laporan', route('admin.laporan.index'));
});

Breadcrumbs::for('admin.laporan.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.laporan.index');
    $trail->push('Tambah Laporan', route('admin.laporan.create'));
});

Breadcrumbs::for('admin.laporan.show', function (BreadcrumbTrail $trail, $laporan) {
    $trail->parent('admin.laporan.index');
    $trail->push('Detail Laporan', route('admin.laporan.show', $laporan));
});

Breadcrumbs::for('admin.laporan.edit', function (BreadcrumbTrail $trail, $laporan) {
    $trail->parent('admin.laporan.index');
    $trail->push('Edit Laporan', route('admin.laporan.edit', $laporan));
});

Breadcrumbs::for('admin.laporan.arsip', function (BreadcrumbTrail $trail) {
    $trail->parent('welcome');
    $trail->push('Arsip Laporan', route('admin.laporan.arsip'));
});

Breadcrumbs::for('admin.laporan.verifikasi', function (BreadcrumbTrail $trail) {
    $trail->parent('welcome');
    $trail->push('Verifikasi Laporan', route('admin.laporan.verifikasi'));
});

Breadcrumbs::for('admin.laporan.verifikasi.edit', function (BreadcrumbTrail $trail, $laporan) {
    $trail->parent('admin.laporan.verifikasi');
    $trail->push($laporan?->classRoom?->fullName, route('admin.laporan.verifikasi.edit', $laporan));
});

Breadcrumbs::for('admin.signature.index', function (BreadcrumbTrail $trail) {
    $trail->parent('welcome');
    $trail->push('Kelola Tanda Tangan', route('admin.signature.index'));
});

Breadcrumbs::for('admin.signature.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.signature.index');
    $trail->push('Tambah Tanda Tangan', route('admin.signature.create'));
});

// ===================== TENAGA PENGAJAR =====================

Breadcrumbs::for('tenaga-pengajar.laporan.index', function (BreadcrumbTrail $trail) {
    $trail->parent('welcome');
    $trail->push('Laporan', route('tenaga-pengajar.laporan.index'));
});

Breadcrumbs::for('tenaga-pengajar.laporan.create', function (BreadcrumbTrail $trail) {
    $trail->parent('tenaga-pengajar.laporan.index');
    $trail->push('Buat Laporan', route('tenaga-pengajar.laporan.create'));
});

Breadcrumbs::for('tenaga-pengajar.laporan.show', function (BreadcrumbTrail $trail, $laporan) {
    $trail->parent('tenaga-pengajar.laporan.index');
    $trail->push($laporan->classRoom->fullName, route('tenaga-pengajar.laporan.show', $laporan));
});


Breadcrumbs::for('tenaga-pengajar.laporan.select', function (BreadcrumbTrail $trail) {
    $trail->parent('tenaga-pengajar.laporan.index');
    $trail->push('Pilih Kelas', route('tenaga-pengajar.laporan.select'));
});

Breadcrumbs::for('tenaga-pengajar.laporan.edit', function (BreadcrumbTrail $trail, $laporan) {
    $trail->parent('tenaga-pengajar.laporan.select');
    $trail->push($laporan?->classRoom?->fullName, route('tenaga-pengajar.laporan.edit', $laporan));
});

Breadcrumbs::for('tenaga-pengajar.kelas.index', function (BreadcrumbTrail $trail) {
    $trail->parent('welcome');
    $trail->push('Kelas', route('tenaga-pengajar.kelas.index'));
});

Breadcrumbs::for('tenaga-pengajar.kelas.show', function (BreadcrumbTrail $trail, $kelas) {
    $trail->parent('tenaga-pengajar.kelas.index');
    $trail->push('Detail Kelas', route('tenaga-pengajar.kelas.show', $kelas));
});

// ===================== KAPRODI =====================

Breadcrumbs::for('kaprodi.laporan.index', function (BreadcrumbTrail $trail) {
    $trail->parent('welcome');
    $trail->push('Verifikasi Laporan', route('kaprodi.laporan.index'));
});

Breadcrumbs::for('kaprodi.laporan.show', function (BreadcrumbTrail $trail, $laporan) {
    $trail->parent('kaprodi.laporan.index');
    $trail->push('Detail Laporan', route('kaprodi.laporan.show', $laporan));
});

Breadcrumbs::for('kaprodi.laporan.verifikasi.edit', function (BreadcrumbTrail $trail, $laporan) {
    $trail->parent('kaprodi.laporan.index');
    $trail->push($laporan->classRoom->fullName, route('kaprodi.laporan.verifikasi.edit', $laporan));
});

Breadcrumbs::for('kaprodi.laporan.arsip', function (BreadcrumbTrail $trail) {
    $trail->parent('welcome');
    $trail->push('Arsip Laporan', route('kaprodi.laporan.arsip'));
});

// ===================== KAPRODI =====================

Breadcrumbs::for('gkmp.laporan.index', function (BreadcrumbTrail $trail) {
    $trail->parent('welcome');
    $trail->push('Semua Laporan', route('gkmp.laporan.index'));
});

Breadcrumbs::for('gkmp.laporan.show', function (BreadcrumbTrail $trail, $laporan) {
    $trail->parent('gkmp.laporan.index');
    $trail->push('Detail Laporan', route('gkmp.laporan.show', $laporan));
});

Breadcrumbs::for('gkmp.laporan.verifikasi', function (BreadcrumbTrail $trail) {
    $trail->parent('welcome');
    $trail->push('Verifikasi Laporan', route('gkmp.laporan.verifikasi'));
});

Breadcrumbs::for('gkmp.laporan.arsip', function (BreadcrumbTrail $trail) {
    $trail->parent('welcome');
    $trail->push('Arsip Laporan', route('gkmp.laporan.arsip'));
});


// ===================== SUPER ADMIN =====================
//
Breadcrumbs::for('super-admin.master-data.index', function (BreadcrumbTrail $trail) {
    $trail->parent('welcome');
    $trail->push('Master Data', route('super-admin.master-data.index'));
});

Breadcrumbs::for('super-admin.tahun-akademik.index', function (BreadcrumbTrail $trail) {
    $trail->parent('super-admin.master-data.index');
    $trail->push('Tahun Akademik', route('super-admin.tahun-akademik.index'));
});

Breadcrumbs::for('super-admin.tahun-akademik.create', function (BreadcrumbTrail $trail) {
    $trail->parent('super-admin.tahun-akademik.index');
    $trail->push('Tambah Tahun Akademik', route('super-admin.tahun-akademik.create'));
});

Breadcrumbs::for('super-admin.tahun-akademik.edit', function (BreadcrumbTrail $trail, $academicYear) {
    $trail->parent('super-admin.tahun-akademik.index');
    $trail->push('Edit Tahun Akademik', route('super-admin.tahun-akademik.edit', $academicYear));
});

Breadcrumbs::for('super-admin.program-studi.index', function (BreadcrumbTrail $trail) {
    $trail->parent('super-admin.master-data.index');
    $trail->push('Program Studi', route('super-admin.program-studi.index'));
});

Breadcrumbs::for('super-admin.program-studi.create', function (BreadcrumbTrail $trail) {
    $trail->parent('super-admin.program-studi.index');
    $trail->push('Tambah Program Studi', route('super-admin.program-studi.create'));
});

Breadcrumbs::for('super-admin.program-studi.edit', function (BreadcrumbTrail $trail, $programStudi) {
    $trail->parent('super-admin.program-studi.index');
    $trail->push('Edit Program Studi', route('super-admin.program-studi.edit', $programStudi));
});

Breadcrumbs::for('super-admin.mata-kuliah.index', function (BreadcrumbTrail $trail) {
    $trail->parent('super-admin.master-data.index');
    $trail->push('Mata Kuliah', route('super-admin.mata-kuliah.index'));
});

Breadcrumbs::for('super-admin.mata-kuliah.create', function (BreadcrumbTrail $trail) {
    $trail->parent('super-admin.mata-kuliah.index');
    $trail->push('Tambah Mata Kuliah', route('super-admin.mata-kuliah.create'));
});

Breadcrumbs::for('super-admin.mata-kuliah.edit', function (BreadcrumbTrail $trail, $course) {
    $trail->parent('super-admin.mata-kuliah.index');
    $trail->push('Edit Mata Kuliah', route('super-admin.mata-kuliah.edit', $course));
});

Breadcrumbs::for('super-admin.kelas.index', function (BreadcrumbTrail $trail) {
    $trail->parent('super-admin.master-data.index');
    $trail->push('Kelas', route('super-admin.kelas.index'));
});

Breadcrumbs::for('super-admin.kelas.create', function (BreadcrumbTrail $trail) {
    $trail->parent('super-admin.kelas.index');
    $trail->push('Tambah Kelas', route('super-admin.kelas.create'));
});

Breadcrumbs::for('super-admin.kelas.edit', function (BreadcrumbTrail $trail, $kelas) {
    $trail->parent('super-admin.kelas.index');
    $trail->push('Edit Kelas', route('super-admin.kelas.edit', $kelas));
});

Breadcrumbs::for('super-admin.laporan.index', function (BreadcrumbTrail $trail) {
    $trail->parent('super-admin.master-data.index');
    $trail->push('Laporan', route('super-admin.laporan.index'));
});

Breadcrumbs::for('super-admin.laporan.create', function (BreadcrumbTrail $trail) {
    $trail->parent('super-admin.laporan.index');
    $trail->push('Buat Laporan', route('super-admin.laporan.create'));
});

Breadcrumbs::for('super-admin.laporan.show', function (BreadcrumbTrail $trail, $report) {
    $trail->parent('super-admin.laporan.index');
    $trail->push('Detail Laporan', route('super-admin.laporan.show', $report));
});

Breadcrumbs::for('super-admin.laporan.edit', function (BreadcrumbTrail $trail, $report) {
    $trail->parent('super-admin.laporan.index');
    $trail->push('Edit Laporan', route('super-admin.laporan.edit', $report));
});

Breadcrumbs::for('super-admin.user.index', function (BreadcrumbTrail $trail) {
    $trail->parent('super-admin.master-data.index');
    $trail->push('User', route('super-admin.user.index'));
});

Breadcrumbs::for('super-admin.user.create', function (BreadcrumbTrail $trail) {
    $trail->parent('super-admin.user.index');
    $trail->push('Tambah User', route('super-admin.user.create'));
});

Breadcrumbs::for('super-admin.user.edit', function (BreadcrumbTrail $trail, User $user) {
    $trail->parent('super-admin.user.index');
    $trail->push('Edit User', route('super-admin.user.edit', $user));
});

Breadcrumbs::for('super-admin.student.index', function (BreadcrumbTrail $trail) {
    $trail->parent('super-admin.master-data.index');
    $trail->push('Mahasiswa', route('super-admin.student.index'));
});

Breadcrumbs::for('super-admin.student.create', function (BreadcrumbTrail $trail) {
    $trail->parent('super-admin.student.index');
    $trail->push('Tambah Mahasiswa', route('super-admin.student.create'));
});

Breadcrumbs::for('super-admin.student.edit', function (BreadcrumbTrail $trail, $student) {
    $trail->parent('super-admin.student.index');
    $trail->push('Edit Mahasiswa', route('super-admin.student.edit', $student));
});
