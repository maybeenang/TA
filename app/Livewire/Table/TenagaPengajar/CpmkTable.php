<?php

namespace App\Livewire\Table\TenagaPengajar;

use App\Dynamics\Column;
use App\Dynamics\Dialog;
use App\Jobs\GenerateReportPDF;
use App\Livewire\DynamicTable;
use App\Livewire\Forms;
use App\Models\Cpmk;
use App\Models\Report;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\On;

class CpmkTable extends DynamicTable
{
    public $relations = ['report'];
    public $showSearchAndPerPage = false;
    public $componentAfter = 'livewire.table.after.cpmk-after';

    public Report $laporan;

    public Forms\FormsEditCpmk $form;

    public Forms\FormsCreateCpmk $createForm;

    #[On('open-edit-cpmk')]
    public function openEditCpmk($id)
    {
        $this->form->mount($this->getRowData($id));
    }


    #[On('close-modal')]
    public function closeEditCpmk()
    {
        $this->form->reset();
        $this->createForm->reset();
    }

    public function save()
    {
        $this->form->save();

        $this->dispatch('close-modal');
    }


    public function saveCreate()
    {
        $this->createForm->save($this->laporan);
        $this->dispatch('close-modal');
    }


    public function delete($id)
    {
        Cpmk::find($id)->delete();
        $this->dispatch('close-modal');
    }

    public function getRowData($id)
    {
        return Cpmk::find($id);
    }

    public function query(): Builder
    {
        return Cpmk::query()
            ->with($this->relations)
            ->where('report_id', $this->laporan->id)
            ->orderBy('created_at', 'asc');
    }

    public function mount(Report $laporan)
    {
        $this->laporan = $laporan;
    }

    public function columns(): array
    {
        return [
            Column::make('code', 'Kode'),
            Column::make('description', 'Deskripsi CMPK'),
            Column::make('criteria', 'Kriteria dan Bentuk'),
            Column::make('average_score', 'Rata Rata Nilai'),
            Column::make('id', ' ')->component('columns.partials.actions.cpmk'),
        ];
    }

    public function dialogs()
    {
        return [
            Dialog::make('dialog.dialogs.edit-cpmk', 'editCpmk'),
            Dialog::make('dialog.dialogs.create-cpmk', 'createCpmk')
        ];
    }
}
