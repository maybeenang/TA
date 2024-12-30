<?php

namespace App\Livewire\Table\Gkmp;

use App\Dynamics\Column;
use App\Dynamics\Dialog;
use App\Enums\ReportStatusEnum;
use App\Livewire\DynamicTable;
use App\Models\AcademicYear;
use App\Models\ClassRoom;
use App\Models\Report;
use App\Models\ReportStatus;
use App\Traits\WithAcademicYear;
use App\Traits\WithAuthProgramStudi;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;

class LaporanTable extends DynamicTable
{
    use WithAcademicYear, WithAuthProgramStudi;

    public $searchColumns = ['classRoom.name', 'classRoom.course.name', 'classRoom.course.code', 'reportStatus.name'];

    public $relations = ['classRoom', 'reportStatus', 'classRoom.course', 'classRoom.lecturer', 'classRoom.lecturer.user'];

    public $componentBefore = 'livewire.table.kelas';

    public $componentAfter = 'livewire.table.after.cpmk-after';

    public $customActionBunttons = 'components.columns.partials.actions.laporan';

    public $routeName = 'gkmp.laporan';

    // forms
    public $reportStatusName;
    public $selectedChangeReport;
    public $reportNote;

    public function getAllReportStatuses()
    {
        return ReportStatusEnum::toSelectArray();
    }

    #[On('send-report-reminder')]
    public function reportReminder($reportId)
    {
        $report = Report::find($reportId);

        if ($report?->classRoom?->lecturer?->user) {
            $report->classRoom->lecturer->user->notify(new \App\Notifications\ReportReminder($report));
        }
    }

    public function changeReportStatus()
    {
        if ($this->reportStatusName === null) {
            return;
        }
        $report = Report::find($this->selectedChangeReport);

        $oldStatusName = $report->reportStatus->name;

        $reportStatusId = ReportStatus::where('name', $this->reportStatusName)->first()->id;
        $report->report_status_id = $reportStatusId;

        // check apakah oldStatusId sama dengan terverifikasi
        if ($oldStatusName === ReportStatusEnum::TERVERIFIKASI->value) {
            $report->verified_at = null;
            $report->signature_gkmp_id = null;
            $report->signature_kaprodi_id = null;
            $report->verifikator_gkmp = null;
            $report->verifikator_kaprodi = null;
        }



        if ($this->reportNote && $this->reportStatusName === 'ditolak') {
            $report->note = $this->reportNote;
        }

        $report->save();

        // check if classroom from report already has a lecturer
        $lecturer = ClassRoom::find($report->class_room_id)->lecturer;

        if ($lecturer && $lecturer?->user) {
            $lecturer->user->notify(new \App\Notifications\ReportStatusUpdated($report));
        }

        $this->reset('reportStatusName');
        $this->dispatch('close-modal');
    }

    #[On('close-modal')]
    public function closeModal()
    {
        $this->reset('reportStatusName');
        $this->reset('selectedChangeReport');
        $this->reset('reportNote');
        $this->reset('lecturerId');
    }

    public $lecturerId;

    public function addLecture($reportId)
    {
        $classroom = Report::find($reportId)->classRoom;

        $classroom->lecturer_id = $this->lecturerId;

        $classroom->save();

        $this->dispatch('close-modal');
    }

    public function query(): Builder
    {
        return Report::query()
            ->with($this->relations)
            ->when($this->academicYearId, function ($query) {
                $query->whereHas('classRoom', function ($query) {
                    $query->where('academic_year_id', $this->academicYearId);
                    $query->whereHas('course', function ($query) {
                        $query->where('program_studi_id', $this->authProgramStudiId);
                    });
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
            Column::make('', 'Tenaga Pengajar')->component('columns.report-classroom-lecturers'),
            Column::make('', 'Status')->component('columns.report-status'),
            Column::make('updated_at', 'Terakhir Diupdate')->component('columns.terakhir-di-update'),
            Column::make('', ' ')->component('columns.partials.actions.semua-laporan-gkmp'),
        ];
    }

    public function dialogs()
    {
        return [
            Dialog::make('dialog.dialogs.ubah-status-laporan', 'laporan')
        ];
    }
}
