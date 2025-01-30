<?php

namespace App\Imports;

use App\Models\Course;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MatakuliahImport implements ToModel, WithHeadingRow
{
    use Importable;


    public function model(array $row)
    {
        try {
            DB::beginTransaction();

            $course = Course::firstOrNew([
                'code' => $row['kode']
            ], [
                'name' => $row['nama'],
                'credit' => $row['sks'],
                'program_studi_id' => auth()->user()->program_studi_id
            ]);
            $course->save();
            DB::commit();

            return $course;
        } catch (\Throwable $th) {

            DB::rollBack();

            return null;
        }
    }
}
