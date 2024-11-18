<?php // routes/breadcrumbs.php

use App\Models\User;
use Diglactic\Breadcrumbs\Breadcrumbs;

use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;
use Illuminate\Support\Facades\Log;

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

Breadcrumbs::for('admin.tenaga-pengajar.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.tenaga-pengajar.index');
    $trail->push('Tambah Tenaga Pengajar', route('admin.tenaga-pengajar.create'));
});

Breadcrumbs::for('admin.mata-kuliah.index', function (BreadcrumbTrail $trail) {
    $trail->parent('welcome');
    $trail->push('Mata Kuliah', route('admin.mata-kuliah.index'));
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
    $trail->push('Edit Laporan', route('tenaga-pengajar.laporan.edit', $laporan));
});

Breadcrumbs::for('tenaga-pengajar.kelas.index', function (BreadcrumbTrail $trail) {
    $trail->parent('welcome');
    $trail->push('Kelas', route('tenaga-pengajar.kelas.index'));
});

Breadcrumbs::for('tenaga-pengajar.kelas.show', function (BreadcrumbTrail $trail, $kelas) {
    $trail->parent('tenaga-pengajar.kelas.index');
    $trail->push('Detail Kelas', route('tenaga-pengajar.kelas.show', $kelas));
});
