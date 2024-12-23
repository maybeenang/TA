<?php

namespace App\Livewire\Table\SuperAdmin;

use App\Dynamics\Column;
use App\Livewire\DynamicTable;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class UserTable extends DynamicTable
{
    public $searchColumns = ['name', 'email'];


    public function query(): Builder
    {
        return User::query()
            ->with(['roles', 'lecturer', 'programStudi']);
    }

    public function columns(): array
    {
        return [
            Column::make('name', 'Nama'),
            Column::make('email', 'Email'),
            Column::make('lecturer.nip', 'NIP'),
            Column::make('roles', 'Role')->component('columns.user-role'),
            Column::make('programStudi.name', 'Program Studi'),
            Column::make('created_at', 'Terkahir online')->component('columns.diff-for-human'),
        ];
    }
}
