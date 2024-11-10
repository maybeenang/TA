<?php

namespace App\Livewire\Table;

use App\Models\Report;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\On;
use Livewire\Component;

#[Lazy]
class StudentGradeTable extends Component
{
    public array $headers = [];

    public Report $laporan;

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
                'NIM' => $student->nim,
                'Nama' => $student->name,
                'Total Nilai' => $totalScore,
            ];
            foreach ($gradeComponents as $gradeComponent) {
                $data[$gradeComponent->name] = $studentGrades->get($gradeComponent->id)->score ?? 0;
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
