<?php

namespace App\Imports;

use App\Models\Course;
use App\Services\AcademicYearService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class KelasImport implements ToModel, WithHeadingRow
{
    use Importable;

    public function model(array $row)
    {
        try {
            DB::beginTransaction();

            $course = Course::firstOrNew([
                'code' => $row['kode_matakuliah']
            ], [
                'name' => $row['nama_matakuliah'],
                'credit' => $row['sks'],
                'program_studi_id' => auth()->user()->program_studi_id
            ]);

            $course->save();

            $course->classRooms()->create([
                'id' => $row['kode'],
                'name' => $row['nama'],
                'academic_year_id' => app(AcademicYearService::class)->getCurrentAcademicYear()->id,
            ]);

            DB::commit();

            return $course;
        } catch (\Throwable $th) {
            DB::rollBack();

            return null;
        }
    }
}
