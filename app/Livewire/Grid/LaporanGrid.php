<?php

namespace App\Livewire\Grid;

use App\Traits\WithAcademicYear;
use Livewire\Component;
use Livewire\WithPagination;

abstract class LaporanGrid extends Component
{
    use WithPagination, WithAcademicYear;

    public $search = '';

    public abstract function query(): \Illuminate\Database\Eloquent\Builder;

    public function filterWithAcademicYear()
    {
        $this->resetPage();
    }

    public function data()
    {
        return $this->query()
            ->whereHas('classroom.academicYear', function ($query) {
                $query->where('id', $this->academicYearId);
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
