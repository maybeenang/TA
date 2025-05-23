<?php

namespace App\Livewire\Table\TenagaPengajar;

use App\Dynamics\Column;
use App\Dynamics\Dialog;
use App\Enums\ReportStatusEnum;
use App\Events\CheckingReport;
use App\Livewire\DynamicTable;
use App\Models\AcademicYear;
use App\Models\ClassRoom;
use App\Models\Report;
use App\Traits\WithAcademicYear;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;

class PilihLaporanTable extends DynamicTable
{
    use WithAcademicYear;

    public $searchColumns = ['classRoom.name', 'classRoom.course.name', 'classRoom.course.code', 'reportStatus.name'];

    public $relations = ['classRoom', 'reportStatus', 'classRoom.course'];

    public $componentBefore = 'livewire.table.kelas';

    public $componentAfter = 'livewire.table.after.cpmk-after';

    public function filterWithAcademicYear()
    {
        $this->resetPage();
    }

    function convertCamelCase($camelCaseString)
    {
        $result = preg_replace("/([a-z])([A-Z])/", '$1 $2', $camelCaseString);
        return ucwords($result);
    }


    function convertKebabCase($camelCaseString)
    {
        $result = preg_replace('/([a-z])([A-Z])/', '$1-$2', $camelCaseString);
        return strtolower($result);
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
            })
            ->whereHas('reportStatus', function ($query) {
                $query->where('name', '!=', ReportStatusEnum::TERVERIFIKASI);
                $query->where('name', '!=', ReportStatusEnum::DIKIRIM);
            });
    }

    public function columns(): array
    {
        return [
            Column::make('classRoom.id', 'Kode Kelas'),
            Column::make('classRoom.name', 'Nama Kelas'),
            Column::make('classRoom.course.code', 'Kode Mata Kuliah'),
            Column::make('classRoom.course.name', 'Nama Mata Kuliah'),
            Column::make('', 'Status')->component('columns.report-status'),
            Column::make('updated_at', 'Terakhir di Update')->component('columns.terakhir-di-update'),
            Column::make('', 'Progres')->component('columns.progres-laporan'),
            Column::make('', ' ')->component('columns.pilih-laporan'),
        ];
    }

    public function dialogs()
    {
        return [
            Dialog::make('dialog.dialogs.confirm-laporan-verifikasi', 'verifikasiLaporan'),
        ];
    }
}
