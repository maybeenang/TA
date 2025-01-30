<?php

namespace App\Livewire\Table;

use App\Dynamics\Column;
use App\Livewire\DynamicTable;
use App\Models\Course;
use App\Traits\WithAuthProgramStudi;
use Illuminate\Database\Eloquent\Builder;

class MataKuliahTable extends DynamicTable
{
    use WithAuthProgramStudi;

    public $searchColumns = ['name', 'code'];
    /*public $relations = ['lecturer'];*/

    /*public $componentBefore = 'livewire.table.mata-kuliah';*/

    public $routeName = 'admin.mata-kuliah';

    public function query(): Builder
    {
        return Course::query()
            ->authProgramStudi();
    }

    public function columns(): array
    {
        return [
            Column::make('code', 'Kode Mata Kuliah'),
            Column::make('name', 'Nama Mata Kuliah'),
            Column::make('credit', 'SKS'),
            Column::make('created_at', 'Dibuat Pada')->component('columns.diff-for-human')->sortable(false),
            Column::make('id', ' ')->component('columns.actions')->sortable(false),
        ];
    }
}
