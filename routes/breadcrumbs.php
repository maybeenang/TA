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

// Home > Blog > [Category]
/*Breadcrumbs::for('category', function (BreadcrumbTrail $trail, $category) {*/
/*    $trail->parent('blog');*/
/*    $trail->push($category->title, route('category', $category));*/
/*});*/
