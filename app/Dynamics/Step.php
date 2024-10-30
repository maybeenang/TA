<?php

namespace App\Dynamics;

class Step
{
    public string $component = 'step.step';

    public string $title;

    public function __construct(string $title)
    {
        $this->title = $title;
    }

    public function component($component)
    {
        $this->component = $component;

        return $this;
    }

    public static function make(string $title)
    {
        return new static($title);
    }
}
