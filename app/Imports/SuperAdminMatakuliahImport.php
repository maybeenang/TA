<?php

namespace App\Imports;

use App\Models\Course;
use App\Models\ProgramStudi;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SuperAdminMatakuliahImport implements ToModel, WithHeadingRow
{
    use Importable;

    public function model(array $row)
    {
        try {

            DB::beginTransaction();

            $course = Course::firstOrNew(['code' => $row['kode']]);

            $course->name = $row['nama'];
            $course->credit = $row['sks'];

            $prodi = ProgramStudi::where('name', $row['program_studi'])->first();

            $course->program_studi_id = $prodi->id ?? null;

            $course->save();

            DB::commit();

            return $course;
        } catch (\Throwable $th) {
            DB::rollBack();

            return null;
        }
    }
}
