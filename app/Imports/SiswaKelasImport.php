<?php

namespace App\Imports;

use App\Models\ClassRoom;
use App\Models\ProgramStudi;
use App\Models\Student;
use App\Models\StudentClassroom;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SiswaKelasImport implements ToModel, WithHeadingRow
{

    public function model(array $row)
    {
        $kodeKelas = $row['kode_kelas'];

        $classRoom = ClassRoom::where('id', $kodeKelas)->first();

        if (!$classRoom) {
            return null;
        }

        try {
            DB::beginTransaction();

            $mahasiswa = Student::firstOrNew([
                'nim' => $row['nim']
            ], [
                'name' => $row['nama_mahasiswa'],
                'program_studi_id' => ProgramStudi::where('name', $row['program_studi'])->first()->id
            ]);

            $mahasiswa->save();

            StudentClassroom::firstOrCreate([
                'student_id' => $mahasiswa->id,
                'class_room_id' => $classRoom->id
            ]);

            DB::commit();

            return $mahasiswa;
        } catch (\Throwable $th) {
            DB::rollBack();

            return null;
        }
    }
}
