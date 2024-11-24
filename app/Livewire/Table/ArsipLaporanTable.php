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
use App\Services\ReportService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;

class ArsipLaporanTable extends DynamicTable
{
    public $searchColumns = ['name'];

    public $relations = ['classRoom', 'reportStatus'];

    public $componentBefore = 'livewire.table.kelas';

    public $componentAfter = 'livewire.table.after.cpmk-after';

    public $customActionBunttons = 'components.columns.partials.actions.laporan';

    public $routeName = 'admin.laporan';

    public $academicYearId;

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
                    $query->where('name', ReportStatusEnum::TERVERIFIKASI->value);
                }
            )
            ->when(
                $this->academicYearId,
                function ($query) {
                    $query->whereHas('classRoom', function ($query) {
                        $query->where('academic_year_id', $this->academicYearId);
                    });
                },
            );
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
            Dialog::make('dialog.dialogs.tolak-laporan', 'tolakLaporan')
        ];
    }

    public function boot(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }
}
