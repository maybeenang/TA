<?php

namespace App\Livewire\Table\SuperAdmin;

use App\Dynamics\Column;
use App\Livewire\DynamicTable;
use App\Models\Report;
use App\Traits\WithAcademicYear;
use Illuminate\Database\Eloquent\Builder;

class LaporanTable extends DynamicTable
{
    use WithAcademicYear;

    public $searchColumns = ['classRoom.name', 'classRoom.course.name', 'classRoom.course.code', 'reportStatus.name'];

    public $relations = ['classRoom', 'reportStatus', 'classRoom.course.programStudi'];

    public $componentBefore = 'livewire.table.kelas';

    public function query(): Builder
    {
        return Report::query()
            ->with($this->relations)
            ->when($this->academicYearId, function ($query) {
                $query->whereHas('classRoom', function ($query) {
                    $query->where('academic_year_id', $this->academicYearId);
                });
            })
            ->orderBy('created_at', 'desc');
    }

    public function columns(): array
    {
        return [
            Column::make('classRoom.id', 'Kode Kelas'),
            Column::make('classRoom.name', 'Nama Kelas'),
            Column::make('classRoom.course.code', 'Kode MK'),
            Column::make('classRoom.course.name', 'Mata Kuliah'),
            Column::make('classRoom.lecturer.user.name', 'Tenaga Pengajar'),
            Column::make('classRoom.course.programStudi.name', 'Program Studi'),
            Column::make('', 'Status')->component('columns.report-status'),
            Column::make('updated_at', 'Terakhir Diupdate')->component('columns.terakhir-di-update'),
            Column::make('id', '')->component('columns.partials.actions.super-admin.laporan-action'),
        ];
    }
}
