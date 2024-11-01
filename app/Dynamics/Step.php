<?php

namespace App\Dynamics;

abstract class Step
{
    public string $component = 'step.step';

    public string $title;

    public bool $showNext = true;

    public bool $showPrevious = true;

    public function __construct(string $title)
    {
        $this->title = $title;
    }

    public function component($component)
    {
        $this->component = $component;

        return $this;
    }

    public function showNext(bool $showNext)
    {
        $this->showNext = $showNext;

        return $this;
    }

    public function showPrevious(bool $showPrevious)
    {
        $this->showPrevious = $showPrevious;

        return $this;
    }

    public abstract function fields(): array;

    public static function make(string $title)
    {
        return new static($title);
    }
}
