<?php

namespace App\Livewire\Table\TenagaPengajar;

use App\Dynamics\Column;
use App\Livewire\DynamicTable;
use App\Models\Cpmk;
use App\Models\Report;
use Illuminate\Database\Eloquent\Builder;

class CpmkTable extends DynamicTable
{
    public $relations = ['report'];
    public $showSearchAndPerPage = false;

    public Report $laporan;

    public function delete($id)
    {
        Cpmk::find($id)->delete();
        $this->dispatch('close-modal');
    }

    public function query(): Builder
    {
        return Cpmk::query()
            ->with($this->relations)
            ->where('report_id', $this->laporan->id);
    }

    public function mount(Report $laporan)
    {
        $this->laporan = $laporan;
    }

    public function columns(): array
    {
        return [
            Column::make('code', 'Kode'),
            Column::make('description', 'Deskripsi CMPK'),
            Column::make('criteria', 'Kriteria dan Bentuk'),
            Column::make('average_score', 'Rata Rata Nilai'),
            Column::make('id', ' ')->component('columns.partials.actions.cpmk'),
        ];
    }
}
