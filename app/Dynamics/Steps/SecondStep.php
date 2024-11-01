<?php

namespace App\Dynamics\Steps;

class SecondStep extends \App\Dynamics\Step
{
    public function fields(): array
    {
        return [
            \App\Dynamics\Field::make('course_method')
                ->label('Metode Perkuliahan'),
        ];
    }
}
