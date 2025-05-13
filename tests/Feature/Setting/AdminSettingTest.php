<?php

use App\Models\User;

test('delete tahun akademik', function () {

    // delete all data from academic_year table
    \App\Models\AcademicYear::truncate();

    // expect all data is gone
    $this->assertDatabaseCount('academic_year', 0);
})->group('sync.tahun_akademik');


it('sync tahun akademik', function () {

    // login with admin
    $admin = User::where('email', 'admin@admin.com');

    // login as admin
    $this->actingAs($admin->first());

    // sync tahun akademik
    $this->post(route('admin.master-data.sync', ['type' => 'tahun_akademik']))
        ->assertStatus(200);
})->group('sync.tahun_akademik');
