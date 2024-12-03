<?php

namespace App\Livewire\Table;

use App\Dynamics\Column;
use App\Livewire\DynamicTable;
use App\Models\AcademicYear;
use App\Models\ClassRoom;
use App\Models\Lecturer;
use App\Traits\WithAcademicYear;
use Illuminate\Database\Eloquent\Builder;
/*use Livewire\Component;*/

class KelasTable extends DynamicTable
{
    use WithAcademicYear;

    public $searchColumns = ['name', 'course.code', 'course.name', 'course.credit', 'lecturer.user.name'];

    public $relations = ['course', 'lecturer', 'academicYear'];

    public $routeName = 'admin.kelas';

    public $componentBefore = 'livewire.table.kelas';

    public $lecturerId;

    public function filterWithAcademicYear()
    {
        $this->resetPage();
    }

    public function getRowData($id)
    {
        return ClassRoom::find($id);
    }

    public function addLecture($classRoomId)
    {
        $classRoom = ClassRoom::find($classRoomId);
        $classRoom->lecturer_id = $this->lecturerId;
        $classRoom->save();

        $this->reset('lecturerId');
        $this->dispatch('close-modal');
    }

    public function query(): Builder
    {
        return ClassRoom::query()
            ->with($this->relations)
            ->when($this->academicYearId, function ($query) {
                $query->where('academic_year_id', $this->academicYearId);
            });
    }

    public function columns(): array
    {
        return [
            Column::make('id', 'Kode'),
            Column::make('name', 'Nama'),
            Column::make('course.code', 'Kode Mata Kuliah'),
            Column::make('course.name', 'Nama Mata Kuliah'),
            Column::make('course.credit', 'SKS'),
            Column::make('id', 'Nama Tenaga Pengajar')->component('columns.classroom-lecturers'),
            /*Column::make('created_at', 'Dibuat Pada')->component('columns.diff-for-human'),*/
            Column::make('id', ' ')->component('columns.actions'),
        ];
    }
}
