<?php

namespace App\Livewire\Table;

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
            ->with(['roles'])
            ->orderBy('created_at', 'desc');
    }

    public function columns(): array
    {
        return [
            Column::make('name', 'Nama'),
            Column::make('email', 'Email'),
            Column::make('roles', 'Role')->component('columns.user-role')->sortable(false),
            /*Column::make('created_at', 'Dibuat Pada')->component('columns.diff-for-human')->sortable(false),*/
            Column::make('id', 'Aksi')->component('columns.actions')->sortable(false),
        ];
    }
}
