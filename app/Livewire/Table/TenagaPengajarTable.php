<?php

namespace App\Livewire\Table;

use App\Dynamics\Column;
use App\Livewire\DynamicTable;
use App\Models\Lecturer;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class TenagaPengajarTable extends DynamicTable
{
    public $searchColumns = ['user.name', 'user.email', 'nip'];

    public $routeName = 'admin.tenaga-pengajar';

    public function query(): Builder
    {
        return Lecturer::query()
            ->with('user')
            // for sorting cheat
            ->join('users', 'lecturers.user_id', '=', 'users.id')
            ->whereHas('user')
            ->select('lecturers.*');
    }

    public function columns(): array
    {
        return [
            Column::make('user.name', 'Nama'),
            Column::make('nip', 'Nip'),
            Column::make('user.email', 'Email'),
            Column::make('id', ' ')->component('columns.actions')->sortable(false),
        ];
    }
}
