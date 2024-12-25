<?php

namespace App\Livewire\Table\Kaprodi;

use App\Dynamics\Column;
use App\Dynamics\Dialog;
use App\Enums\ReportStatusEnum;
use App\Livewire\DynamicTable;
use App\Models\Report;
use App\Services\ReportService;
use App\Traits\WithAcademicYear;
use App\Traits\WithAuthProgramStudi;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\On;

class VerifikasiLaporanTable extends DynamicTable
{
    use WithAcademicYear, WithAuthProgramStudi;

    public $searchColumns = ['classRoom.name', 'classRoom.course.name', 'classRoom.course.code', 'reportStatus.name'];

    public $relations = ['classRoom', 'reportStatus', 'classRoom.course', 'classRoom.lecturer', 'classRoom.lecturer.user'];

    public $componentBefore = 'livewire.table.kelas';

    public $componentAfter = 'livewire.table.after.cpmk-after';

    private ReportService $reportService;

    // forms
    public $catatan;

    public function tolakLaporan($id)
    {
        $this->reportService->tolakLaporan($id, $this->catatan ?? '');
        $this->dispatch('close-modal');

        session()->flash('message', 'Laporan Berhasil Ditolak');
    }

    #[On('close-modal')]
    public function closeModal()
    {
        $this->reset('catatan');
    }

    public function query(): Builder
    {
        return Report::query()
            ->with($this->relations)
            ->whereHas('reportStatus', function ($query) {
                $query->where('name', ReportStatusEnum::DIKIRIM);
            })
            ->where('signature_kaprodi_id', null)
            ->when($this->academicYearId, function ($query) {
                $query->whereHas('classRoom', function ($query) {
                    $query->where('academic_year_id', $this->academicYearId);
                    $query->whereHas('course', function ($query) {
                        $query->where('program_studi_id', $this->authProgramStudiId);
                    });
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

    public function dialogs()
    {
        return [
            Dialog::make('dialog.dialogs.tolak-laporan', 'tolakLaporan')
        ];
    }

    public function boot(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }
}
