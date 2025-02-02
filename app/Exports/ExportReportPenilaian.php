<?php

namespace App\Exports;

use App\Models\Report;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ExportReportPenilaian implements FromView, ShouldAutoSize
{
    use Exportable;

    public function __construct(
        public Report $report
    ) {}

    public function view(): \Illuminate\Contracts\View\View
    {
        $header = [
            'id',
            'NIM',
            'Nama',
        ];

        $header = array_merge($header, $this->report->gradeComponents->pluck('name')->toArray());

        $data = $this->report->grades->map(function ($grade) {
            $student = $grade->student;
            $studentGrades = $grade->studentGrades->keyBy('grade_component_id');
            $gradeComponents = $this->report->gradeComponents;

            $data = [
                'id' => $student->id,
                'NIM' => $student->nim,
                'Nama' => $student->name,
            ];

            foreach ($gradeComponents as $gradeComponent) {
                $data[$gradeComponent->name] = $studentGrades->get($gradeComponent->id)->score ?? 0;
            }
            return $data;
        });


        return view('excel.report-penilaian', [
            'header' => $header,
            'data' => $data
        ]);
    }
}
