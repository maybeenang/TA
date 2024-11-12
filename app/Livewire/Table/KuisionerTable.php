<?php

namespace App\Livewire\Table;

use App\Models\Report;
use Livewire\Attributes\Validate;
use Livewire\Component;

class KuisionerTable extends Component
{

    public $editingId;

    #[Validate([
        'editingData.*' => [
            'required',
            'numeric',
            'min:0',
            'max:200',
        ],
        'editingData.statement' => 'required',
        'editingData.id' => 'required',
    ])]
    public $editingData = [];

    public Report $laporan;

    public function startEditing($id)
    {
        $this->editingId = $id;
        $this->editingData = $this->data()->firstWhere('id', $id);
    }

    public function cancelEditing()
    {
        $this->editingId = null;
        $this->editingData = [];
    }

    public function saveEdit()
    {
        $this->validate();

        $kuisioner = $this->laporan->quistionnaires->firstWhere('id', $this->editingId);

        $kuisioner->update([
            'strongly_agree' => $this->editingData['strongly_agree'],
            'agree' => $this->editingData['agree'],
            'disagree' => $this->editingData['disagree'],
            'strongly_disagree' => $this->editingData['strongly_disagree'],
        ]);

        $this->cancelEditing();
    }

    public function headers()
    {
        return [
            'No',
            'Komponen Penilaian',
            'Sangat Setuju',
            'Setuju',
            'Tidak Setuju',
            'Sangat Tidak Setuju',
        ];
    }

    public function data()
    {
        return $this->laporan->quistionnaires->map(function ($item, $index) {
            return [
                'id' => $item->id,
                'no' => $index + 1,
                'statement' => $item->statement,
                'strongly_agree' => $item->strongly_agree,
                'agree' => $item->agree,
                'disagree' => $item->disagree,
                'strongly_disagree' => $item->strongly_disagree,
            ];
        });
    }

    public function averages()
    {
        $data =  [
            'strongly_agree' => $this->laporan->quistionnaires->avg('strongly_agree'),
            'agree' => $this->laporan->quistionnaires->avg('agree'),
            'disagree' => $this->laporan->quistionnaires->avg('disagree'),
            'strongly_disagree' => $this->laporan->quistionnaires->avg('strongly_disagree'),
        ];

        // return with round
        return collect($data)->map(function ($item) {
            return round($item, 2);
        });
    }

    public function mount(Report $laporan)
    {
        $this->laporan = $laporan;
    }

    public function render()
    {
        return view('livewire.table.kuisioner-table');
    }
}
