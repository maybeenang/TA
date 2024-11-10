<?php

namespace App\Livewire\Forms;

use App\Models\GradeComponent;
use Livewire\Attributes\Validate;
use Livewire\Form;

class FormsEditGradeComponent extends Form
{
    public $id;
    public $name;
    public $weight;

    public function rules()
    {
        return [
            'name' => 'required',
            'weight' => 'required|numeric',
        ];
    }

    public function save()
    {
        $this->validate();

        $gradeComponent = GradeComponent::find($this->id);
        $gradeComponent->update([
            'name' => $this->name,
            'weight' => $this->weight / 100,
        ]);
    }

    public function mount($gradeComponent)
    {
        $this->id = $gradeComponent->id;
        $this->name = $gradeComponent->name;
        // delete % from weight
        $this->weight = str_replace('%', '', $gradeComponent->weight);
    }
}
