<?php

namespace App\Dynamics;

use App\Enums\FieldTypesEnum;

class Field
{
    public string $name;
    public string $label;
    public FieldTypesEnum $type = FieldTypesEnum::TEXT;

    public array $rules;

    public string $key;

    public function __construct(string $name, string $key = null)
    {
        $this->name = $name;

        $this->key = $key ?? $name;

        // default label is the name with Capitalized first letter
        $this->label = ucfirst($name);
    }

    public function label(string $label)
    {
        $this->label = $label;

        return $this;
    }

    public function type(FieldTypesEnum $type)
    {
        $this->type = $type;

        return $this;
    }

    public function rules(array $rules)
    {
        $this->rules = $rules;

        return $this;
    }

    public static function make(string $name, string $key = null)
    {
        return new static($name, $key);
    }
}
