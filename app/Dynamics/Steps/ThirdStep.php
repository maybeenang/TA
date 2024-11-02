<?php

namespace App\Dynamics\Steps;

class ThirdStep extends \App\Dynamics\Step
{
    public string $component = 'step.laporan.third-step';
    public function fields(): array
    {
        return [
            \App\Dynamics\Field::make('evaluasi')
                ->label('Evaluasi Diri Perkuliahan'),
            \App\Dynamics\Field::make('rencana')
                ->label('Rencana Tindak Lanjut'),
        ];
    }
}
