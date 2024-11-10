<?php

namespace App\Livewire\Table;

use App\Dynamics\Column;
use App\Dynamics\Dialog;
use App\Enums\ReportStatusEnum;
use App\Livewire\DynamicTable;
use App\Models\AcademicYear;
use App\Models\ClassRoom;
use App\Models\Report;
use App\Models\ReportStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;


class LaporanTable extends DynamicTable
{
    public $searchColumns = ['name'];

    public $relations = ['classRoom', 'reportStatus'];

    public $componentBefore = 'livewire.table.kelas';

    public $customActionBunttons = 'components.columns.partials.actions.laporan';

    public $routeName = 'admin.laporan';

    public $academicYearId;

    // forms
    public $reportStatusName;

    public function getAllReportStatuses()
    {
        return ReportStatusEnum::toSelectArray();
    }

    public function changeReportStatus($reportId)
    {
        if ($this->reportStatusName === null) {
            return;
        }
        $report = Report::find($reportId);
        $reportStatusId = ReportStatus::where('name', $this->reportStatusName)->first()->id;
        $report->report_status_id = $reportStatusId;
        $report->save();

        $this->reset('reportStatusName');
        $this->dispatch('close-modal');
    }

    public function filterWithAcademicYear()
    {
        $this->resetPage();
    }

    public function getAllAcademicYears()
    {
        return AcademicYear::query()->get();
    }

    public function query(): Builder
    {
        return Report::query()
            ->with($this->relations)
            ->when($this->academicYearId, function ($query) {
                $query->whereHas('classRoom', function ($query) {
                    $query->where('academic_year_id', $this->academicYearId);
                });
            });
    }

    public function columns(): array
    {
        return [
            Column::make('id', 'Kode'),
            Column::make('classRoom.id', 'Kode Kelas'),
            Column::make('classRoom.name', 'Nama Kelas'),
            Column::make('classRoom.course.code', 'Kode Mata Kuliah'),
            Column::make('classRoom.course.name', 'Nama Mata Kuliah'),
            Column::make('reportStatus.name', 'Status')->component('columns.report-status'),
            Column::make('id', ' ')->component('columns.actions')->sortable(false),
        ];
    }

    public function dialogs()
    {
        return [
            Dialog::make('dialog.dialogs.ubah-status-laporan', 'laporan')
        ];
    }
}
