<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create 30 courses, each course has 3 classrooms
        Course::factory(30)->create();

        // create 90 classrooms
        Course::all()->each(function ($course) {
            $course->classRooms()->createMany(
                [
                    ['name' => 'RA', 'academic_year_id' => 1, 'mode' => 'offline'],
                    ['name' => 'RB', 'academic_year_id' => 1, 'mode' => 'offline'],
                    ['name' => 'RC', 'academic_year_id' => 1, 'mode' => 'offline'],
                ]
            );
        });
    }
}
