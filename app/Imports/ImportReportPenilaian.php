<?php

namespace App\Imports;

use App\Models\Report;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;

class ImportReportPenilaian implements ToModel, WithHeadingRow
{
    use Importable;

    public function __construct(
        public Report $report
    ) {}

    public function model(array $row)
    {
        $grade = $this->report->grades->firstWhere('student_id', $row['id']);

        if ($grade) {
            DB::transaction(function () use ($grade, $row) {
                $grade->studentGrades->each(function ($studentGrade) use ($row) {

                    // convert name to lower case and replace space with underscore
                    $name = strtolower(str_replace(' ', '_', $studentGrade->gradeComponent->name));

                    $studentGrade->update([
                        'score' => $row[$name] ?? 0,
                    ]);
                });
            });
        }

        return null;
    }
}
