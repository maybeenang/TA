<?php

namespace App\Services;

use App\Models\Student;
use Illuminate\Support\Facades\DB;

class StudentService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }


    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            $student = Student::create([
                'nim' => $data['nim'],
                'name' => $data['name'],
                'program_studi_id' => $data['programStudi'],
            ]);
            return $student;
        });
    }

    public function update(Student $student, array $data)
    {
        return DB::transaction(function () use ($student, $data) {
            $student->update([
                'nim' => $data['nim'],
                'name' => $data['name'],
                'program_studi_id' => $data['programStudi'] ?? $student->program_studi_id,
            ]);
            return $student;
        });
    }
}
