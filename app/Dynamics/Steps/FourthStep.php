<?php

namespace App\Dynamics\Steps;

class FourthStep extends \App\Dynamics\Step
{
    public string $component = 'step.laporan.fourth-step';

    public function fields(): array
    {
        return [
            \App\Dynamics\Field::make('course_method')
                ->label('Metode Perkuliahan'),
        ];
    }
}
