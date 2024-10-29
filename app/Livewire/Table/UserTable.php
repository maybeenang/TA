<?php

namespace App\Livewire\Table;

use App\Dynamics\Column;
use App\Livewire\DynamicTable;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class UserTable extends DynamicTable
{
    public $searchColumns = ['name', 'email'];

    public $routeName = 'admin.user';


    public function query(): Builder
    {
        return User::query()
            ->with(['roles']);
    }

    public function columns(): array
    {
        return [
            Column::make('name', 'Nama'),
            Column::make('email', 'Email'),
            Column::make('roles', 'Role')->component('columns.user-role')->sortable(false),
            Column::make('created_at', 'Terkahir online')->component('columns.diff-for-human')->sortable(false),
            Column::make('created_at', 'Dibuat Pada')->component('columns.date')->sortable(),
            Column::make('id', ' ')->component('columns.actions')->sortable(false),
        ];
    }
}
