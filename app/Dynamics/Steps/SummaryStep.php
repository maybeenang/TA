<?php

namespace App\Dynamics\Steps;

class SummaryStep extends \App\Dynamics\Step
{
    public string $component = 'step.laporan.summary-step';
    public function fields(): array
    {
        return [
            \App\Dynamics\Field::make('course_method')
                ->label('Metode Perkuliahan'),
        ];
    }
}
