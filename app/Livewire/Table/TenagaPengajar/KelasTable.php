<?php

namespace App\Livewire\Table\TenagaPengajar;

use App\Dynamics\Column;
use App\Livewire\DynamicTable;
use App\Models\AcademicYear;
use App\Models\ClassRoom;
use App\Models\Lecturer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

/*use Livewire\Component;*/

class KelasTable extends DynamicTable
{
    public $searchColumns = ['name',];

    public $relations = ['course', 'lecturer', 'academicYear'];

    public $routeName = 'tenaga-pengajar.kelas';

    public $componentBefore = 'livewire.table.kelas';

    public $academicYearId;

    public function filterWithAcademicYear()
    {
        /*dd($this->academicYearId);*/
        $this->resetPage();
    }

    public function getAllAcademicYears()
    {
        return AcademicYear::query()->get();
    }

    public function getRowData($id)
    {
        return ClassRoom::find($id);
    }

    public function query(): Builder
    {
        return ClassRoom::query()
            ->with($this->relations)
            ->when($this->academicYearId, function ($query) {
                $query->where('academic_year_id', $this->academicYearId);
            })
            ->whereHas('lecturer', function ($query) {
                $query->where('user_id', Auth::id());
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
            Column::make('mode', 'Mode Kuliah'),
            Column::make('id', ' ')->component('columns.partials.actions.kelas-tenaga-pengajar'),
        ];
    }
}
