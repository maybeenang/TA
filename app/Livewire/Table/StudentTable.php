<?php

namespace App\Livewire\Table;

use App\Dynamics\Column;
use App\Livewire\DynamicTable;
use App\Models\Student;
use App\Models\User;
use App\Traits\WithAuthProgramStudi;
use Illuminate\Database\Eloquent\Builder;

class StudentTable extends DynamicTable
{
    use WithAuthProgramStudi;

    public $searchColumns = ['name', 'nim'];

    public function query(): Builder
    {
        return Student::query()
            ->with(['programStudi'])
            ->whereHas('programStudi', function ($query) {
                $query->where('id', $this->authProgramStudiId);
            });
    }

    public function columns(): array
    {
        return [
            Column::make('nim', 'NIM'),
            Column::make('name', 'Nama'),
            Column::make('programStudi.name', 'Program Studi'),
            Column::make('id', '')->component('columns.partials.actions.admin.mahasiswa-action'),
        ];
    }
}
