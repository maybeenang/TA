<?php

namespace App\Dynamics;

class Column
{
    public string $component = 'columns.column';

    public string|array $key;

    public string $label;

    public bool $sortable = true;

    public function __construct(string|array $key, string $label)
    {
        $this->key = $key;
        $this->label = $label;
    }

    public function component($component)
    {
        $this->component = $component;

        return $this;
    }

    public function sortable($sortable = true)
    {
        $this->sortable = $sortable;

        return $this;
    }

    public static function make(string|array $key, string $label)
    {
        return new static($key, $label);
    }
}
