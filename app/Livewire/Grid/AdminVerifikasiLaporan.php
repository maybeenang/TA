<?php

namespace App\Livewire\Grid;

use App\Enums\ReportStatusEnum;
use App\Models\Report;
use App\Traits\WithAcademicYear;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AdminVerifikasiLaporan extends Component
{
    use WithAcademicYear;

    public $relations = ['classRoom', 'reportStatus'];

    public function data()
    {
        return Report::query()
            ->with($this->relations)
            ->when($this->academicYearId, function ($query) {
                $query->whereHas('classRoom', function ($query) {
                    $query->where('academic_year_id', $this->academicYearId);
                });
            })
            ->whereHas('reportStatus', function ($query) {
                $query->where('name', ReportStatusEnum::DIKIRIM->value);
            })
            ->latest()
            ->limit(5)
            ->get();
    }


    public function render()
    {
        return view('livewire.grid.admin-verifikasi-laporan');
    }
}
