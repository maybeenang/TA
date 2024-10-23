<?php

namespace App\Livewire\Table;

use App\Dynamics\Column;
use App\Livewire\DynamicTable;
use App\Models\AcademicYear;
use Illuminate\Database\Eloquent\Builder;

class TahunAkademikTable extends DynamicTable
{
    public $searchColumns = ['name'];
    /*public $relations = ['lecturer'];*/

    /*public $componentBefore = 'livewire.table.mata-kuliah';*/

    public function query(): Builder
    {
        return AcademicYear::query()
            ->orderBy('created_at', 'desc');
    }

    public function columns(): array
    {
        return [
            Column::make('name', 'Nama'),
            Column::make('start_date', 'Mulai')->component('columns.date')->sortable(false),
            Column::make('end_date', 'Selesai')->component('columns.date')->sortable(false),
            Column::make('created_at', 'Dibuat Pada')->component('columns.diff-for-human')->sortable(false),
            Column::make('id', 'Aksi')->component('columns.actions')->sortable(false),
        ];
    }
}
