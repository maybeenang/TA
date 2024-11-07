<?php

namespace App\Livewire\Table\TenagaPengajar;

use App\Dynamics\Column;
use App\Dynamics\Dialog;
use App\Livewire\DynamicTable;
use App\Livewire\Forms\FormsEditPresensi;
use App\Models\AttendanceAndActivity;
use App\Models\Report;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\On;

class PresensiDanKeaktifanTable extends DynamicTable
{
    public $relations = ['report'];
    public $showSearchAndPerPage = false;
    public $perPage = 20;

    public $componentAfter = 'livewire.table.after.cpmk-after';

    public FormsEditPresensi $editPresensi;
    public Report $laporan;

    #[On('open-edit-presensi')]
    public function openEditPresensi($id)
    {
        $this->editPresensi->mount($this->getRowData($id));
    }

    public function save()
    {
        $this->editPresensi->save();
        $this->dispatch('close-modal');
    }

    #[On('close-modal')]
    public function closeEditPresensi()
    {
        $this->editPresensi->reset();
    }

    public function getRowData($id)
    {
        return AttendanceAndActivity::find($id);
    }


    public function query(): Builder
    {
        return AttendanceAndActivity::query()
            ->with($this->relations)
            ->orderBy('week')
            ->where('report_id', $this->laporan->id);
    }

    public function columns(): array
    {
        return [
            Column::make('meeting_name', 'Pertemuan (minggu)'),
            Column::make('student_present', 'Peserta Hadir'),
            Column::make('student_active', 'Peserta yang aktif'),
            Column::make('id', ' ')->component('columns.partials.actions.presensi-dan-keaktifan'),
        ];
    }

    public function dialogs()
    {
        return [
            Dialog::make('dialog.dialogs.edit-presensi', 'editPresensi'),
        ];
    }
}
