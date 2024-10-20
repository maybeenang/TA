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

Breadcrumbs::for('tenaga-pengajar.index', function (BreadcrumbTrail $trail) {
    $trail->parent('welcome');
    $trail->push('Tenaga Pengajar', route('tenaga-pengajar.index'));
});

Breadcrumbs::for('tenaga-pengajar.create', function (BreadcrumbTrail $trail) {
    $trail->parent('tenaga-pengajar.index');
    $trail->push('Tambah Tenaga Pengajar', route('tenaga-pengajar.create'));
});
