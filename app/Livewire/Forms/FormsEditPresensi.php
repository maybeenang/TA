<?php

namespace App\Livewire\Forms;

use App\Models\AttendanceAndActivity;
use Livewire\Attributes\Validate;
use Livewire\Form;

class FormsEditPresensi extends Form
{
    public $id;
    public $meeting_name = '';
    public $student_present = 0;
    public $student_active = 0;

    public function rules(): array
    {
        return [
            'student_present' => 'nullable|numeric',
            'student_active' => 'nullable|numeric',
        ];
    }

    public function save()
    {
        $this->validate();

        $attendance = AttendanceAndActivity::find($this->id);
        $attendance->update([
            'student_present' => $this->student_present ?? 0,
            'student_active' => $this->student_active ?? 0,
        ]);
    }

    public function mount($data)
    {
        $this->id = $data->id;
        $this->meeting_name = $data->meeting_name;
        $this->student_present = $data->student_present ?? 0;
        $this->student_active = $data->student_active ?? 0;
    }
}
