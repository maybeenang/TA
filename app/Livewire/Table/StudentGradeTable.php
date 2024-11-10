<?php

namespace App\Livewire\Table;

use App\Events\StudentGradeUpdated;
use App\Models\Report;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\On;
use Livewire\Component;

#[Lazy]
class StudentGradeTable extends Component
{
    public array $headers = [];

    public Report $laporan;

    public $editingId;
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
        $this->refresh();
    }

    public function gradeComponents()
    {
        return $this->laporan->gradeComponents;
    }

    #[On('refresh-student-grade-table')]
    public function refresh()
    {
        $this->laporan->refresh();
        $this->headers = [
            'NIM',
            'Nama',
            'Total Nilai',
            ...$this->gradeComponents()->pluck('name')->toArray(),
        ];
    }

    public function data()
    {
        return $this->laporan->grades->map(function ($grade) {
            $student = $grade->student;
            $studentGrades = $grade->studentGrades->keyBy('grade_component_id');
            $totalScore = $grade->total_score;
            $gradeComponents = $this->gradeComponents();
            $data = [
                'student_id' => $student->id,
                'NIM' => $student->nim,
                'Nama' => $student->name,
                'Total Nilai' => $totalScore,
            ];
            foreach ($gradeComponents as $gradeComponent) {
                $data[$gradeComponent->name] = $studentGrades->get($gradeComponent->id)->score ?? 0;
                // get student grade id
                $data[$gradeComponent->name . '_id'] = $studentGrades->get($gradeComponent->id)->id ?? null;
            }
            return $data;
        });
    }



    public function mount(Report $laporan)
    {
        $this->laporan = $laporan;
        $this->headers = [
            'NIM',
            'Nama',
            'Total Nilai',
            ...$this->gradeComponents()->pluck('name')->toArray(),
        ];
    }

    public function placeholder()
    {
        return view('livewire.table.placeholder');
    }

    public function render()
    {
        return view('livewire.table.student-grade-table', [
            'headers' => $this->headers,
        ]);
    }
}
