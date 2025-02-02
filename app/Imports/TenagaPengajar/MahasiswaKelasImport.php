<?php

namespace App\Imports\TenagaPengajar;

use App\Models\Student;
use App\Models\StudentClassroom;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MahasiswaKelasImport implements ToModel, WithHeadingRow
{

    use Importable;

    protected $kelas_id;

    public function __construct($kelas_id)
    {
        $this->kelas_id = $kelas_id;
    }

    public function model(array $row)
    {
        try {
            DB::beginTransaction();

            $mahasiswa = Student::firstOrNew([
                'nim' => $row['nim']
            ], [
                'name' => $row['nama_mahasiswa'],
                'program_studi_id' => auth()->user()->program_studi_id
            ]);

            $mahasiswa->save();

            StudentClassroom::firstOrCreate([
                'student_id' => $mahasiswa->id,
                'class_room_id' => $this->kelas_id
            ]);

            DB::commit();

            return $mahasiswa;
        } catch (\Throwable $th) {
            DB::rollBack();

            return null;
        }
    }
}
