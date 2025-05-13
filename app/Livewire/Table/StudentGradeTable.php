<?php

namespace App\Livewire\Table;

use App\Events\GradeComponentUpdated;
use App\Events\StudentGradeUpdated;
use App\Jobs\GenerateReportPDF;
use App\Models\Report;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Lazy]
class StudentGradeTable extends Component
{

    public Report $laporan;

    public $editingId;

    #[Validate([
        'editingData.*' => [
            'required',
            'numeric',
            'min:0',
            'max:200',
        ],
        'editingData.NIM' => 'required',
        'editingData.Nama' => 'required',
        'editingData.Nilai' => 'required',
        'editingData.Total Nilai' => 'required',
        'editingData.student_id' => 'required',
    ])]
    public $editingData = [];

    public function startEditing($student_id)
    {
        $this->editingId = $student_id;
        $this->editingData = $this->data()->firstWhere('student_id', $student_id);
    }

    public function cancelEditing()
    {
        $this->editingId = null;
        $this->editingData = [];
    }

    public function saveEdit()
    {
        $this->validate();

        $student = $this->laporan->grades->firstWhere('student_id', $this->editingId);

        $studentGrades = $student->studentGrades->keyBy('grade_component_id');
        $gradeComponents = $this->gradeComponents();
        foreach ($gradeComponents as $gradeComponent) {
            $studentGrade = $studentGrades->get($gradeComponent->id);
            $studentGrade->update([
                'score' => $this->editingData[$gradeComponent->name],
            ]);
        }

        event(new StudentGradeUpdated($this->editingId, $this->laporan));

        $this->cancelEditing();

        $this->laporan->refresh();

        session()->flash('message', 'Data berhasil diperbarui!');
    }

    public function gradeComponents()
    {
        return $this->laporan->gradeComponents;
    }

    #[On('refresh-student-grade-table')]
    public function refresh()
    {
        event(new GradeComponentUpdated($this->laporan));
        $this->laporan->refresh();
    }

    public function data()
    {
        return $this->laporan->grades->map(function ($grade) {
            $student = $grade->student;
            $studentGrades = $grade->studentGrades->keyBy('grade_component_id');
            $totalScore = $grade->total_score;
            $letterScore = $grade->letter ?? '-';
            $gradeComponents = $this->gradeComponents();

            $data = [
                'student_id' => $student->id,
                'NIM' => $student->nim,
                'Nama' => $student->name,
                'Nilai' => $letterScore,
                'Pembulatan' => round($totalScore),
                'Total Nilai' => $totalScore,
            ];
            foreach ($gradeComponents as $gradeComponent) {
                $data[$gradeComponent->name] = $studentGrades->get($gradeComponent->id)->score ?? 0;
            }
            return $data;
        });
    }


    public function headers()
    {
        return [
            'NIM',
            'Nama',
            'Nilai',
            'Pembulatan',
            'Total Nilai',
            ...$this->gradeComponents()->pluck('name')->toArray(),
        ];
    }



    public function mount(Report $laporan)
    {
        $this->laporan = $laporan;
    }

    public function placeholder()
    {
        return view('livewire.table.placeholder');
    }

    public function render()
    {
        return view('livewire.table.student-grade-table', []);
    }
}
