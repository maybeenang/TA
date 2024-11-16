<?php

namespace App\Livewire\Forms;

use App\Jobs\GenerateReportPDF;
use App\Models\Cpmk;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Form;

class FormsEditCpmk extends Form
{
    public $id;

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

    public function save()
    {
        $this->validate();

        $cpmk = Cpmk::find($this->id);
        $cpmk->update([
            'code' => $this->code,
            'description' => $this->description,
            'criteria' => $this->criteria,
            'average_score' => $this->average_score,
        ]);
    }


    public function mount($cpmk)
    {
        $this->id = $cpmk->id;
        $this->code = $cpmk->code ?? '';
        $this->description = $cpmk->description ?? '';
        $this->criteria = $cpmk->criteria ?? '';
        $this->average_score = $cpmk->average_score ?? '';
    }
}
