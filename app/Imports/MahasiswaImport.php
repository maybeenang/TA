<?php

namespace App\Imports;

use App\Models\Student;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MahasiswaImport implements ToModel, WithHeadingRow
{
    use Importable;

    public function model(array $row)
    {
        try {
            DB::beginTransaction();

            $mahasiswa = Student::firstOrNew([
                'nim' => $row['nim']
            ], [
                'name' => $row['nama'],
                'program_studi_id' => auth()->user()->program_studi_id
            ]);

            $mahasiswa->save();

            DB::commit();

            return $mahasiswa;
        } catch (\Throwable $th) {

            DB::rollBack();

            return null;
        }
    }
}
