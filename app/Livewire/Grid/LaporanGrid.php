<?php

namespace App\Livewire\Grid;

use App\Enums\RolesEnum;
use App\Traits\WithAcademicYear;
use App\Traits\WithAuthProgramStudi;
use Livewire\Component;
use Livewire\WithPagination;

abstract class LaporanGrid extends Component
{
    use WithPagination, WithAcademicYear, WithAuthProgramStudi;

    public $search = '';

    public $role = RolesEnum::ADMIN->value;

    public abstract function query(): \Illuminate\Database\Eloquent\Builder;

    public function data()
    {
        return $this->query()
            ->whereHas('classRoom', function ($query) {
                $query->where('academic_year_id', $this->academicYearId);
                $query->whereHas('course', function ($query) {
                    $query->where('program_studi_id', $this->authProgramStudiId);
                });
            })
            ->when($this->search !== '', function ($query) {
                // search by classroom name or classroom course name or classroom course code
                $query->whereHas('classRoom', function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%')
                        ->orWhereHas('course', function ($query) {
                            $query->where('name', 'like', '%' . $this->search . '%')
                                ->orWhere('code', 'like', '%' . $this->search . '%');
                        });
                });
            })
            ->orderBy('updated_at', 'desc')
            ->paginate();
    }

    public function render()
    {
        return view('livewire.grid.laporan-grid');
    }
}
