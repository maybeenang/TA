<?php

namespace App\Livewire\Table\SuperAdmin;

use App\Dynamics\Column;
use App\Livewire\DynamicTable;
use App\Models\Course;
use Illuminate\Database\Eloquent\Builder;

class MataKuliahTable extends DynamicTable
{
    public $searchColumns = ['name', 'code', 'credit', 'programStudi.name'];

    public $routeName = 'admin.mata-kuliah';

    public function query(): Builder
    {
        return Course::query()
            ->with(['programStudi'])
            ->authProgramStudi();
    }

    public function columns(): array
    {
        return [
            Column::make('code', 'Kode Mata Kuliah'),
            Column::make('name', 'Nama Mata Kuliah'),
            Column::make('credit', 'SKS'),
            Column::make('programStudi.name', 'Program Studi'),
            Column::make('id', ' ')->component('columns.partials.actions.super-admin.mata-kuliah-action'),
        ];
    }
}
