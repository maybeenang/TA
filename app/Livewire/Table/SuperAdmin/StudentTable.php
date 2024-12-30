<?php

namespace App\Livewire\Table\SuperAdmin;

use App\Dynamics\Column;
use App\Livewire\DynamicTable;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class StudentTable extends DynamicTable
{
    public $searchColumns = ['name', 'nim'];

    public function query(): Builder
    {
        return Student::query()
            ->with(['programStudi']);
    }

    public function columns(): array
    {
        return [
            Column::make('nim', 'NIM'),
            Column::make('name', 'Nama'),
            Column::make('programStudi.name', 'Program Studi'),
            Column::make('id', '')->component('columns.partials.actions.super-admin.student-action'),
        ];
    }
}
