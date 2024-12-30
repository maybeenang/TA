<?php

namespace App\Livewire\Table;

use App\Dynamics\Column;
use App\Dynamics\Dialog;
use App\Livewire\DynamicTable;
use App\Models\ClassRoom;
use App\Models\Student;
use App\Models\StudentClassroom;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;

class ClassroomStudentTable extends DynamicTable
{
    public ClassRoom $kelas;

    public $searchColumns = ['student.name', 'student.nim'];

    public $perPage = 150;

    public function query(): Builder
    {
        return StudentClassroom::query()
            ->with('classroom', 'student')
            ->where('class_room_id', $this->kelas->id)
            ->orderBy(
                DB::table('students')
                    ->select('nim')
                    ->whereColumn('students.id', 'student_id')
                    ->take(1),
                'asc'
            );
    }

    public function mount(ClassRoom $kelas)
    {
        $this->kelas = $kelas;
    }


    public function columns(): array
    {
        return [
            Column::make('student.nim', 'NIM'),
            Column::make('student.name', 'NAMA'),
        ];
    }
}
