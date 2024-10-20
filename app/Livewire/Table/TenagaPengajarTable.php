<?php

namespace App\Livewire\Table;

use App\Dynamics\Column;
use App\Livewire\DynamicTable;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
/*use Livewire\Component;*/

class TenagaPengajarTable extends DynamicTable
{
    public $searchColumns = ['name', 'email'];
    public $relations = ['lecturer'];

    public function query(): Builder
    {
        return User::query();
    }

    public function columns(): array
    {
        return [
            Column::make('name', 'Nama'),
            Column::make(['lecturer', 'nip'], 'Nip')->sortable(false),
            Column::make('email', 'Email'),
            Column::make('created_at', 'Dibuat Pada')->component('columns.diff-for-human')->sortable(false),
            Column::make('id', 'Aksi')->component('columns.actions')->sortable(false),
        ];
    }
}
