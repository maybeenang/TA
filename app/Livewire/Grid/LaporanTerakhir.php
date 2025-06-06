<?php

namespace App\Livewire\Grid;

use App\Models\Report;
use App\Traits\WithAcademicYear;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LaporanTerakhir extends Component
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
            ->whereHas('classRoom.lecturer', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->latest()
            ->limit(10)
            ->get();
    }


    public function render()
    {
        return view('livewire.grid.laporan-terakhir');
    }
}
