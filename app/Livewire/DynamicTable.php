<?php

namespace App\Livewire;

use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

abstract class DynamicTable extends Component
{
    use WithPagination;

    public $perPage = 10;

    public $sortBy = '';

    public $sortDirection = 'asc';

    #[Url()]
    public $search = '';

    public $searchColumns = [];

    public $componentBefore = '';

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
        return $this
            ->query()
            ->when($this->sortBy !== '', function ($query) {
                $query->orderBy($this->sortBy, $this->sortDirection);
            })
            ->when($this->search !== '', function ($query) {
                $query->where(function ($query) {
                    foreach ($this->searchColumns as $column) {
                        $query->orWhere($column, 'like', '%' . $this->search . '%');
                    }
                });
            })
            ->paginate($this->perPage);
    }

    public function render()
    {
        return view('livewire.dynamic-table');
    }
}
