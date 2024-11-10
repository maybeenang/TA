<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class FormsEditGradeScale extends Form
{
    public $id;

    public $letter;

    public $max_score;

    public $min_score;

    public function rules()
    {
        return [
            'max_score' => 'required|numeric|gt:min_score',
            'min_score' => 'required|numeric|lt:max_score',
        ];
    }

    public function save()
    {
        $this->validate();

        $gradeScale = \App\Models\GradeScale::find($this->id);

        $gradeScale->update([
            'max_score' => $this->max_score,
            'min_score' => $this->min_score,
        ]);
    }

    public function mount($gradeScale)
    {
        $this->id = $gradeScale->id;
        $this->letter = $gradeScale->letter;
        $this->max_score = $gradeScale->max_score;
        $this->min_score = $gradeScale->min_score;
    }
}
