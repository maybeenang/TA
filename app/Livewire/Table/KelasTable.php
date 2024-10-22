<?php

namespace App\Livewire\Table;

use App\Dynamics\Column;
use App\Livewire\DynamicTable;
use App\Models\ClassRoom;
use Illuminate\Database\Eloquent\Builder;
/*use Livewire\Component;*/

class KelasTable extends DynamicTable
{
    public $searchColumns = ['name',];
    /*public $relations = ['lecturer'];*/

    public function query(): Builder
    {
        return ClassRoom::query();
    }

    public function columns(): array
    {
        return [
            Column::make('name', 'Nama'),
            Column::make('created_at', 'Dibuat Pada')->component('columns.diff-for-human')->sortable(false),
            Column::make('id', 'Aksi')->component('columns.actions')->sortable(false),
        ];
    }
}
