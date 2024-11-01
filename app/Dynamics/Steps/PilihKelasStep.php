<?php

namespace App\Dynamics\Steps;

class PilihKelasStep extends \App\Dynamics\Step
{
    public function __construct(string $title)
    {
        parent::__construct($title);
        $this->component('step.pilih-kelas');
    }

    public function fields(): array
    {
        return [
            \App\Dynamics\Field::make('kelas')
                ->label('Kelas')
                ->rules(['required', 'string']),
        ];
    }
}
