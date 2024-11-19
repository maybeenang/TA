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
use Livewire\Attributes\On;

class VerifikasiLaporanTable extends DynamicTable
{
    public $searchColumns = ['name'];

    public $relations = ['classRoom', 'reportStatus'];

    public $componentBefore = 'livewire.table.kelas';

    public $componentAfter = 'livewire.table.after.cpmk-after';

    public $customActionBunttons = 'components.columns.partials.actions.laporan';

    public $routeName = 'admin.laporan';

    public $academicYearId;

    // forms
    public $reportStatusName;
    public $selectedChangeReport;
    public $reportNote;

    public function getAllReportStatuses()
    {
        return ReportStatusEnum::toSelectArray();
    }

    public function changeReportStatus()
    {
        if ($this->reportStatusName === null) {
            return;
        }
        $report = Report::find($this->selectedChangeReport);
        $reportStatusId = ReportStatus::where('name', $this->reportStatusName)->first()->id;
        $report->report_status_id = $reportStatusId;

        if ($this->reportNote && $this->reportStatusName === 'ditolak') {
            $report->note = $this->reportNote;
        }

        $report->save();

        $this->reset('reportStatusName');
        $this->dispatch('close-modal');
    }

    #[On('close-modal')]
    public function closeModal()
    {
        $this->reset('reportStatusName');
        $this->reset('selectedChangeReport');
        $this->reset('reportNote');
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
            ->whereHas(
                'reportStatus',
                function ($query) {
                    $query->where('name', ReportStatusEnum::DIKIRIM);
                }
            )
            ->when($this->academicYearId, function ($query) {
                $query->whereHas('classRoom', function ($query) {
                    $query->where('academic_year_id', $this->academicYearId);
                });
            });
    }

    public function columns(): array
    {
        return [
            Column::make('classRoom.id', 'Kode Kelas'),
            Column::make('classRoom.name', 'Nama Kelas'),
            Column::make('classRoom.course.code', 'Kode MK'),
            Column::make('classRoom.course.name', 'Mata Kuliah'),
            Column::make('', 'Status')->component('columns.report-status'),
            Column::make('updated_at', 'Terakhir Diupdate')->component('columns.terakhir-di-update'),
            Column::make('', '')->component('columns.partials.actions.verifikasi-laporan'),
        ];
    }

    public function dialogs()
    {
        return [
            Dialog::make('dialog.dialogs.ubah-status-laporan', 'laporan')
        ];
    }
}
