<?php

namespace App\Livewire\Table\TenagaPengajar;

use App\Dynamics\Column;
use App\Dynamics\Dialog;
use App\Events\GradeComponentUpdated;
use App\Livewire\DynamicTable;
use App\Livewire\Forms;
use App\Models\Cpmk;
use App\Models\GradeComponent;
use App\Models\Report;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\On;

class GradeComponentTable extends DynamicTable
{
    public $relations = ['report'];
    public $showSearchAndPerPage = false;
    public $componentAfter = 'livewire.table.after.cpmk-after';

    public $perPage = 100;

    public Report $laporan;

    public Forms\FormsCreateGradeComponent $createForm;
    public Forms\FormsEditGradeComponent $editForm;

    public function saveCreate()
    {
        $this->createForm->save($this->laporan);
        $this->dispatch('close-modal');
        $this->dispatch('refresh-student-grade-table');
    }

    public function delete($id)
    {
        GradeComponent::find($id)->delete();
        $this->dispatch('close-modal');
        $this->dispatch('refresh-student-grade-table');
    }

    #[On('open-edit-grade-component')]
    public function openEdit($id)
    {
        $this->editForm->mount(GradeComponent::find($id));
    }

    public function saveEdit()
    {
        $this->editForm->save();
        $this->dispatch('close-modal');
        $this->dispatch('refresh-student-grade-table');
    }

    #[On('close-modal')]
    public function closeEdit()
    {
        $this->editForm->reset();
    }

    public function query(): Builder
    {
        return GradeComponent::query()
            ->with($this->relations)
            ->where('report_id', $this->laporan->id);
    }

    public function mount(Report $laporan)
    {
        $this->laporan = $laporan;
    }

    public function columns(): array
    {
        return [
            Column::make('name', 'Penilaian'),
            Column::make('weight', 'Persentase'),
            Column::make('id', ' ')->component('columns.partials.actions.grade-component'),
        ];
    }

    public function dialogs()
    {
        return [
            Dialog::make('dialog.dialogs.create-grade-component', 'createGradeComponent'),
            Dialog::make('dialog.dialogs.edit-grade-component', 'eidtGradeComponent')
        ];
    }
}
