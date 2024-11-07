<?php

namespace App\Livewire\Forms;

use App\Models\Cpmk;
use App\Models\Report;
use Livewire\Attributes\Validate;
use Livewire\Form;

class FormsCreateCpmk extends Form
{
    public string $code = '';

    public string $description = '';

    public string $criteria = '';

    public string $average_score = '';

    public function rules(): array
    {
        return [
            'code' => 'required',
            'description' => 'required',
            'criteria' => 'required',
            'average_score' => 'required|numeric',
        ];
    }

    public function save(Report $laporan)
    {
        $this->validate();

        $laporan->cpmks()->create([
            'code' => $this->code,
            'description' => $this->description,
            'criteria' => $this->criteria,
            'average_score' => $this->average_score,
        ]);

        $this->reset();
    }
}
