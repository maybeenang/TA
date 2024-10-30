<?php

namespace App\Livewire\Forms;

use App\Dynamics\Step;
use Livewire\Attributes\Url;
use Livewire\Component;

class LaporanWizard extends Component
{

    public function steps(): array
    {
        return [
            Step::make('Step 1'),
            Step::make('Step 2'),
            Step::make('Step 3'),
            Step::make('Step 4'),
            Step::make('Step 5'),
        ];
    }

    public function getCurrentStep()
    {
        return $this->steps()[$this->currentStep];
    }

    public function nextStep()
    {
        if ($this->currentStep < count($this->steps()) - 1) {
            $this->currentStep++;
        } else {
            $this->currentStep = count($this->steps()) - 1;
        }
    }

    public function previousStep()
    {
        if ($this->currentStep > 0) {
            $this->currentStep--;
        } else {
            $this->currentStep = 0;
        }
    }

    #[Url()]
    public $currentStep;

    public function mount(int $currentStep = 0)
    {
        $this->currentStep = $currentStep;
    }


    public function render()
    {
        return view('livewire.forms.laporan-wizard');
    }
}
