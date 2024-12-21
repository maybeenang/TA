<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Student::factory(200)->create();

        // assign random classrooms to random students
        /*$students = Student::all();*/
        /**/
        /*$students->each(function ($student) {*/
        /*    $classrooms = \App\Models\ClassRoom::inRandomOrder()->limit(rand(1, 3))->get();*/
        /*    $student->studentClassrooms()->createMany(*/
        /*        $classrooms->map(function ($classroom) {*/
        /*            return ['class_room_id' => $classroom->id];*/
        /*        })->toArray()*/
        /*    );*/
        /*});*/
    }
}
