<?php

namespace App\Livewire\Table\TenagaPengajar;

use App\Dynamics\Column;
use App\Livewire\DynamicTable;
use App\Models\AcademicYear;
use App\Models\ClassRoom;
use App\Models\Report;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;


class LaporanTable extends DynamicTable
{
    public $searchColumns = ['name'];

    public $relations = ['classRoom', 'reportStatus'];

    public $componentBefore = 'livewire.table.kelas';


    public $academicYearId;

    public function filterWithAcademicYear()
    {
        $this->resetPage();
    }

    public function getAllAcademicYears()
    {
        return AcademicYear::query()->get();
    }

    function convertCamelCase($camelCaseString)
    {
        // Tambahkan spasi sebelum huruf kapital yang diikuti oleh huruf kecil
        $result = preg_replace("/([a-z])([A-Z])/", '$1 $2', $camelCaseString);
        // Ubah kata pertama dari setiap kata menjadi huruf besar
        return ucwords($result);
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
            Column::make('classRoom.course.code', 'Kode Mata Kuliah'),
            Column::make('classRoom.course.name', 'Nama Mata Kuliah'),
            Column::make('reportStatus.name', 'Status Laporan')->component('columns.report-status'),
            Column::make('', 'Progres')->component('columns.progres-laporan'),
            Column::make('updated_at', 'Terakhir Diupdate')->component('columns.date'),
            Column::make('id', ' ')->component('columns.pilih-laporan'),
        ];
    }
}
