<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Student;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Storage::deleteDirectory('pdfs');
        Storage::disk('public')->deleteDirectory('signatures');
        Storage::disk('public')->deleteDirectory('profile-photos');

        $this->call(
            [
                UserSeeder::class,
                RoleSeeder::class,
                ReportStatusSeeder::class,
                LecturerSeeder::class,
                /*AcademicYearSeeder::class,*/
                /*CourseSeeder::class,*/
                /*StudentSeeder::class,*/
            ]
        );
    }
}
