<?php

namespace App\Livewire\Table\SuperAdmin;

use App\Dynamics\Column;
use App\Livewire\DynamicTable;
use App\Models\AcademicYear;
use App\Models\ProgramStudi;
use Illuminate\Database\Eloquent\Builder;

class ProgramStudiTable extends DynamicTable
{
    public $searchColumns = ['name'];

    public function query(): Builder
    {
        return ProgramStudi::query();
    }

    public function columns(): array
    {
        return [
            Column::make('id', 'Kode'),
            Column::make('name', 'Nama'),
            Column::make('id', ' ')->component('columns.partials.actions.super-admin.program-studi-action'),
        ];
    }
}
