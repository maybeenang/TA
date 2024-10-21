<?php // routes/breadcrumbs.php

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

Breadcrumbs::for('admin.tenaga-pengajar.create', function (BreadcrumbTrail $trail) {
    $trail->parent('tenaga-pengajar.index');
    $trail->push('Tambah Tenaga Pengajar', route('admin.tenaga-pengajar.create'));
});

Breadcrumbs::for('admin.mata-kuliah.index', function (BreadcrumbTrail $trail) {
    $trail->parent('welcome');
    $trail->push('Mata Kuliah', route('admin.mata-kuliah.index'));
});

Breadcrumbs::for('admin.tahun-akademik.index', function (BreadcrumbTrail $trail) {
    $trail->parent('welcome');
    $trail->push('Tahun Akademik', route('admin.tahun-akademik.index'));
});

Breadcrumbs::for('admin.tahun-akademik.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.tahun-akademik.index');
    $trail->push('Tambah Tahun Akademik', route('admin.tahun-akademik.create'));
});
