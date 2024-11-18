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
        // delete all pdf files in storage
        Storage::deleteDirectory('pdfs');

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

        // assign random classrooms to random students
        $students = Student::all();

        $students->each(function ($student) {
            $classrooms = \App\Models\ClassRoom::inRandomOrder()->limit(rand(1, 3))->get();
            $student->studentClassrooms()->createMany(
                $classrooms->map(function ($classroom) {
                    return ['class_room_id' => $classroom->id];
                })->toArray()
            );
        });
    }
}
