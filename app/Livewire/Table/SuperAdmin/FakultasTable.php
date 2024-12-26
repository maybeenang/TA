<?php

namespace App\Livewire\Table\SuperAdmin;

use App\Dynamics\Column;
use App\Livewire\DynamicTable;
use App\Models\Fakultas;
use App\Traits\WithAcademicYear;
use Illuminate\Database\Eloquent\Builder;

class FakultasTable extends DynamicTable
{
    use WithAcademicYear;

    public $searchColumns = ['name'];

    public function query(): Builder
    {
        return Fakultas::query();
    }

    public function columns(): array
    {
        return [
            Column::make('name', 'Nama'),
            Column::make('', 'Program Studi')->component('columns.fakultas-program-studi'),
            Column::make('id', '')->component('columns.partials.actions.super-admin.fakultas-action'),
        ];
    }
}
