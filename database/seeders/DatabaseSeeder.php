<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Student;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(
            [
                UserSeeder::class,
                RoleSeeder::class,
                ReportStatusSeeder::class,
                LecturerSeeder::class,
                AcademicYearSeeder::class,
                CourseSeeder::class,
            ]
        );
        Student::factory(200)->create();
    }
}
