<?php

namespace App\Livewire\Table\TenagaPengajar;

use App\Dynamics\Column;
use App\Livewire\DynamicTable;
use App\Models\Quistionnaire;
use App\Models\Report;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;


class KuisionerTable extends DynamicTable
{
    public $relations = ['report'];
    public $showSearchAndPerPage = false;
    public Report $laporan;

    public function query(): Builder
    {
        return Quistionnaire::query()
            ->with($this->relations)
            ->where('report_id', $this->laporan->id);
    }

    public function columns(): array
    {
        return [
            Column::make('statement', 'Komponen Penilaian'),
            Column::make('strongly_agree', 'Sangat Setuju'),
            Column::make('agree', 'Setuju'),
            Column::make('disagree', 'Tidak Setuju'),
            Column::make('strongly_disagree', 'Sangat Tidak Setuju'),
        ];
    }
}
