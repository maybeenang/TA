<?php

namespace App\Livewire\Table;

use App\Dynamics\Column;
use App\Livewire\DynamicTable;
use App\Models\ClassRoom;
use App\Models\Lecturer;
use Illuminate\Database\Eloquent\Builder;
/*use Livewire\Component;*/

class KelasTable extends DynamicTable
{
    public $searchColumns = ['name',];
    public $relations = ['course', 'lecturer', 'academicYear'];

    public $routeName = 'admin.kelas';

    public function getAllLecturers()
    {
        return Lecturer::all();
    }

    public function getRowData($id)
    {
        return ClassRoom::find($id);
    }

    public $lecturerId;

    public function addLecture($classRoomId)
    {
        /*dd($classRoomId, $this->lecturerId);*/
        $classRoom = ClassRoom::find($classRoomId);
        $classRoom->lecturer_id = $this->lecturerId;
        $classRoom->save();

        $this->reset('lecturerId');
        $this->dispatch('close-modal');
    }

    public function query(): Builder
    {
        return ClassRoom::query()
            ->with($this->relations);
    }

    public function columns(): array
    {
        return [
            Column::make('id', 'Kode'),
            Column::make('name', 'Nama'),
            Column::make('course.code', 'Kode Mata Kuliah')->sortable(false),
            Column::make('course.name', 'Nama Mata Kuliah')->sortable(false),
            Column::make('course.credit', 'SKS')->sortable(false),
            Column::make('id', 'Nama Tenaga Pengajar')->component('columns.classroom-lecturers')->sortable(false),
            Column::make('created_at', 'Dibuat Pada')->component('columns.diff-for-human')->sortable(false),
            Column::make('id', ' ')->component('columns.actions')->sortable(false),
        ];
    }
}
