<?php

namespace App\Dynamics;

class Dialog
{
    public string $component = 'dialog.dialogs.index';

    public string $model = 'dialogModel';

    public function __construct(string $component, string $model)
    {
        $this->component = $component;
        $this->model = $model;
    }

    public static function make(string $component, string $model)
    {
        return new static($component, $model);
    }
}
