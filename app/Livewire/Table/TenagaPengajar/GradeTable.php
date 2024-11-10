<?php

namespace App\Livewire\Table\TenagaPengajar;

use App\Dynamics\Column;
use App\Livewire\DynamicTable;
use App\Models\Grade;
use App\Models\Report;
use App\Models\StudentGrade;
use Illuminate\Database\Eloquent\Builder;

class GradeTable extends DynamicTable
{
    public $showSearchAndPerPage = false;
    /*public $componentAfter = 'livewire.table.after.cpmk-after';*/

    public Report $laporan;

    public function query(): Builder
    {
        return StudentGrade::query();
    }

    public function mount(Report $laporan)
    {
        $this->laporan = $laporan;
    }

    public function columns(): array
    {
        return [
            Column::make('id', ' '),
        ];
    }
}
