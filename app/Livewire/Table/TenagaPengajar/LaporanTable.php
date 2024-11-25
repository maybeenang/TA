<?php

namespace App\Livewire\Table\TenagaPengajar;

use App\Dynamics\Column;
use App\Dynamics\Dialog;
use App\Events\CheckingReport;
use App\Livewire\DynamicTable;
use App\Models\AcademicYear;
use App\Models\ClassRoom;
use App\Models\Report;
use App\Traits\WithAcademicYear;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;

class LaporanTable extends DynamicTable
{
    use WithAcademicYear;

    public $searchColumns = ['name'];

    public $relations = ['classRoom', 'reportStatus'];

    public $componentBefore = 'livewire.table.kelas';

    public $componentAfter = 'livewire.table.after.cpmk-after';

    public function filterWithAcademicYear()
    {
        $this->resetPage();
    }

    #[On('checking-report')]
    public function ajukanVerifikasi($id)
    {
        if ($id) {
            broadcast(new CheckingReport($id));
        }
    }

    public function query(): Builder
    {
        return Report::query()
            ->with($this->relations)
            ->when($this->academicYearId, function ($query) {
                $query->whereHas('classRoom', function ($query) {
                    $query->where('academic_year_id', $this->academicYearId);
                });
            })
            ->whereHas('classRoom.lecturer', function ($query) {
                $query->where('user_id', Auth::id());
            });
    }

    public function columns(): array
    {
        return [
            Column::make('classRoom.id', 'Kode Kelas'),
            Column::make('classRoom.name', 'Nama Kelas'),
            Column::make('classRoom.course.code', 'Kode MK'),
            Column::make('classRoom.course.name', 'Mata Kuliah'),
            Column::make('', 'Status Laporan')->component('columns.report-status'),
            Column::make('updated_at', 'Terakhir Diupdate')->component('columns.terakhir-di-update'),
            Column::make('', ' ')->component('columns.partials.actions.laporan-tenaga-pengajar'),
        ];
    }

    public function dialogs()
    {
        return [
            Dialog::make('dialog.dialogs.confirm-laporan-verifikasi', 'verifikasiLaporan'),
        ];
    }
}
