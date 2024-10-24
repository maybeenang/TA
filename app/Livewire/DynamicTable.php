<?php

namespace App\Livewire;

use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

abstract class DynamicTable extends Component
{
    use WithPagination;

    public $perPage = 10;

    public $sortBy = 'created_at';

    public $sortDirection = 'desc';

    #[Url()]
    public $search = '';

    public $searchColumns = [];

    public $componentBefore = '';

    public array $partialActions = [];

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
        return $this
            ->query()
            ->when($this->sortBy !== '', function ($query) {
                if (str_contains($this->sortBy, '.')) {
                    $relationship = explode('.', $this->sortBy);
                    $query->orderBy($relationship[0] . 's' . '.' . $relationship[1], $this->sortDirection);
                } else {
                    $query->orderBy($this->sortBy, $this->sortDirection);
                }
                /*$query->orderBy($this->sortBy, $this->sortDirection);*/
            })
            ->when($this->search !== '', function ($query) {
                $query->where(function ($query) {
                    foreach ($this->searchColumns as $column) {
                        if (str_contains($column, '.')) {
                            $relationship = explode('.', $column);
                            $query->orWhereHas($relationship[0], function ($query) use ($relationship) {
                                $query->where($relationship[1], 'like', '%' . $this->search . '%');
                            });
                        } else {
                            $query->orWhere($column, 'like', '%' . $this->search . '%');
                        }
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
