<?php

namespace App\Livewire;

use App\Traits\AdvanceSearchAndSort;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

abstract class DynamicTable extends Component
{
    use WithPagination, AdvanceSearchAndSort;

    public $perPage = 10;

    public $sortBy = 'created_at';

    public $sortDirection = 'desc';

    #[Url()]
    public $search = '';

    public $searchColumns = [];

    public $showSearchAndPerPage = true;

    // custom component
    public $componentBefore = '';
    public $componentAfter = '';
    public $customActionBunttons = '';
    // end custom component


    public $routeName = '';

    public abstract function query(): \Illuminate\Database\Eloquent\Builder;

    public abstract function columns(): array;


    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function sort($field)
    {
        $this->resetPage();

        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortBy = $field;
    }


    public function data()
    {

        $query = $this->query();

        if ($this->search !== '') {
            $query->where(function ($query) {
                foreach ($this->searchColumns as $column) {
                    if (str_contains($column, '.')) {
                        $relationship = explode('.', $column);

                        // get last element of array, then get all element except the last element
                        $lastElement = end($relationship);
                        array_pop($relationship);

                        // gabungkan semua element array yang sudah dihilangkan last element dengan sambungkan dengan titik
                        $relationship = implode('.', $relationship);

                        // cari data yang memiliki relasi dengan table lain
                        $query->orWhereHas($relationship, function ($query) use ($lastElement) {
                            $query->where($lastElement, 'like', '%' . $this->search . '%');
                        });
                    } else {
                        $query->orWhere($column, 'like', '%' . $this->search . '%');
                    }
                }
            });
        }

        return $query
            ->when($this->sortBy !== '', function ($query) {
                if (str_contains($this->sortBy, '.')) {
                    $relationship = explode('.', $this->sortBy);
                    $query->orderBy($relationship[0] . 's' . '.' . $relationship[1], $this->sortDirection);
                } else {
                    $query->orderBy($this->sortBy, $this->sortDirection);
                }
            })
            ->paginate($this->perPage);
    }

    public function render()
    {
        return view('livewire.dynamic-table');
    }
}
