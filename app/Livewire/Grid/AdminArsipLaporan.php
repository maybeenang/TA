<?php

namespace App\Livewire\Grid;

use App\Enums\ReportStatusEnum;
use App\Models\Report;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class AdminArsipLaporan extends LaporanGrid
{

    public function query(): Builder
    {
        return Report::query()
            ->with(['reportStatus', 'classRoom', 'classRoom.course'])
            ->whereHas('reportStatus', function ($query) {
                $query->where('name', ReportStatusEnum::TERVERIFIKASI->value);
            });
    }

    public function mount(string $role = 'admin')
    {
        $this->role = $role;
    }
}
