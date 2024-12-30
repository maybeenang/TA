<?php

namespace App\Livewire\Table;

use App\Dynamics\Column;
use App\Livewire\DynamicTable;
use App\Models\AcademicYear;
use Illuminate\Database\Eloquent\Builder;

class TahunAkademikTable extends DynamicTable
{
    public $searchColumns = ['name', 'semester'];

    public $routeName = 'admin.tahun-akademik';

    public function query(): Builder
    {
        return AcademicYear::query()
            ->orderBy('start_date', 'desc');
    }

    public function columns(): array
    {
        return [
            Column::make('fullName', 'Nama'),
            Column::make('start_date', 'Mulai')->component('columns.date')->sortable(false),
            Column::make('end_date', 'Selesai')->component('columns.date')->sortable(false),
        ];
    }
}
