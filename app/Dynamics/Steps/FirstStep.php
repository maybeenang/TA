<?php

namespace App\Dynamics\Steps;

class FirstStep extends \App\Dynamics\Step
{
    public function fields(): array
    {
        return [
            \App\Dynamics\Field::make('classroom')
                ->label('Kelas'),
            \App\Dynamics\Field::make('course')
                ->label('Mata Kuliah'),
            \App\Dynamics\Field::make('course_code')
                ->label('Kode MK'),
            \App\Dynamics\Field::make('course_credit')
                ->label('SKS'),
            \App\Dynamics\Field::make('grade')
                ->label('Semester'),
            \App\Dynamics\Field::make('chief_lecturer')
                ->label('Dosen Penanggung Jawab'),
            \App\Dynamics\Field::make('lecturer')
                ->label('Dosen Penanggung Jawab'),
            \App\Dynamics\Field::make('students_count')
                ->label('Jumlah Mahasiswa'),
        ];
    }
}
