<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;

trait AdvanceSearchAndSort
{

    /**
     * Handle recursive search through nested relations
     */
    protected function searchThroughRelation($query, $relations, $column, $searchTerm)
    {
        $relation = array_shift($relations);

        return $query->orWhereHas($relation, function ($q) use ($relations, $column, $searchTerm) {
            if (empty($relations)) {
                $q->where($column, 'like', '%' . $searchTerm . '%');
            } else {
                $this->searchThroughRelation($q, $relations, $column, $searchTerm);
            }
        });
    }

    /**
     * Handle nested search for multiple relations
     */
    protected function handleNestedSearch($query, $column, $searchTerm)
    {
        $parts = explode('.', $column);
        $searchColumn = array_pop($parts);
        $relations = $parts;

        return $this->searchThroughRelation($query, $relations, $searchColumn, $searchTerm);
    }

    /**
     * Build the search conditions
     */
    protected function buildSearchConditions($query, $searchTerm)
    {
        return $query->where(function ($query) use ($searchTerm) {
            foreach ($this->searchColumns as $column) {
                if (str_contains($column, '.')) {
                    $this->handleNestedSearch($query, $column, $searchTerm);
                } else {
                    $query->orWhere($query->getModel()->getTable() . '.' . $column, 'like', '%' . $searchTerm . '%');
                }
            }
        });
    }
}
