<?php

namespace App\Livewire\Forms;

use App\Dynamics\Steps;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;

class LaporanWizard extends Component
{

    public function steps(): array
    {
        return [
            Steps\FirstStep::make('Tahap 1'),
            Steps\SecondStep::make('Tahap 2'),
            Steps\ThirdStep::make('Tahap 3'),
            Steps\FourthStep::make('Tahap 4'),
            Steps\FifthStep::make('Tahap 5'),
            Steps\SummaryStep::make('Ringkasan'),
        ];
    }

    public function getCurrentStep()
    {
        return $this->steps()[$this->currentStep];
    }

    #[On('nextStep')]
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
    public $currentStep = 0;


    public function render()
    {
        return view('livewire.forms.laporan-wizard');
    }
}
