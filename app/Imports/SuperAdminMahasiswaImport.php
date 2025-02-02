<?php

namespace App\Imports;

use App\Models\Fakultas;
use App\Models\ProgramStudi;
use App\Models\Student;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SuperAdminMahasiswaImport implements ToModel, WithHeadingRow
{
    use Importable;

    public function model(array $row)
    {
        try {
            DB::beginTransaction();

            $fakultas = $row['fakultas'];

            $fakultas = Fakultas::firstOrCreate([
                'name' => $fakultas
            ]);

            $programStudi = $row['program_studi'];

            $programStudi = ProgramStudi::firstOrCreate([
                'name' => $programStudi,
                'fakultas_id' => $fakultas->id
            ]);

            $mahasiswa = Student::firstOrNew([
                'nim' => $row['nim']
            ], [
                'name' => $row['nama'],
                'program_studi_id' => $programStudi->id
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
