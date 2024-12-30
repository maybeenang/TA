<?php

namespace App\Livewire\Table\SuperAdmin;

use App\Dynamics\Column;
use App\Livewire\DynamicTable;
use App\Models\ClassRoom;
use App\Traits\WithAcademicYear;
use Illuminate\Database\Eloquent\Builder;

class KelasTable extends DynamicTable
{
    use WithAcademicYear;

    public $searchColumns = ['name', 'course.code', 'course.name', 'course.credit'];

    public $relations = ['course', 'lecturer', 'academicYear', 'lecturer.user'];

    public $perPage = 500;

    public function query(): Builder
    {
        return ClassRoom::query()
            ->with($this->relations)
            ->when($this->academicYearId, function ($query) {
                $query->where('academic_year_id', $this->academicYearId);
            })
            ->orderBy('id', 'asc');
    }

    public function columns(): array
    {
        return [
            Column::make('id', 'Kode'),
            Column::make('name', 'Nama'),
            Column::make('course.code', 'Kode Mata Kuliah'),
            Column::make('course.name', 'Nama Mata Kuliah'),
            Column::make('course.credit', 'SKS'),
            Column::make('lecturer.user.name', 'Tenaga Pengajar'),
            Column::make('id', '')->component('columns.partials.actions.super-admin.kelas-action'),
        ];
    }
}
