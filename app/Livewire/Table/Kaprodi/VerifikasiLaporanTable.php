<?php

namespace App\Livewire\Table\Kaprodi;

use App\Dynamics\Column;
use App\Enums\ReportStatusEnum;
use App\Livewire\DynamicTable;
use App\Models\Report;
use App\Traits\WithAcademicYear;
use Illuminate\Database\Eloquent\Builder;

class VerifikasiLaporanTable extends DynamicTable
{
    use WithAcademicYear;

    public $searchColumns = ['classRoom.name', 'classRoom.course.name', 'classRoom.course.code', 'reportStatus.name'];

    public $relations = ['classRoom', 'reportStatus'];

    public $componentBefore = 'livewire.table.kelas';

    public function query(): Builder
    {
        return Report::query()
            ->with($this->relations)
            ->whereHas('reportStatus', function ($query) {
                $query->where('name', ReportStatusEnum::DIKIRIM);
            })
            ->when($this->academicYearId, function ($query) {
                $query->whereHas('classRoom.academicYear', function ($query) {
                    $query->where('id', $this->academicYearId);
                });
            })
            ->orderBy('updated_at', 'desc');
    }

    public function columns(): array
    {
        return [
            Column::make('classRoom.id', 'Kode Kelas'),
            Column::make('classRoom.name', 'Nama Kelas'),
            Column::make('classRoom.course.code', 'Kode MK'),
            Column::make('classRoom.course.name', 'Mata Kuliah'),
            Column::make('', 'Status')->component('columns.report-status'),
            Column::make('', '')->component('columns.partials.actions.verifikasi-laporan-kaprodi'),
        ];
    }
}
