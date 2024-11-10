<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class FormsCreateGradeComponent extends Form
{
    public $name;
    public $weight;

    public function rules()
    {
        return [
            'name' => 'required',
            'weight' => 'required|numeric',
        ];
    }

    public function save($report)
    {
        $this->validate();

        $report->gradeComponents()->create([
            'name' => $this->name,
            'weight' => $this->weight / 100,
        ]);
    }
}
