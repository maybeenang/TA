<?php

namespace App\Dynamics\Steps;

class FifthStep extends \App\Dynamics\Step
{
    public string $component = 'step.laporan.fifth-step';
    public function fields(): array
    {
        return [
            \App\Dynamics\Field::make('course_method')
                ->label('Metode Perkuliahan'),
        ];
    }
}
