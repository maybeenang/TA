<?php

namespace App\Imports;

use App\Models\AcademicYear;
use App\Models\ClassRoom;
use App\Models\Course;
use App\Models\ProgramStudi;
use App\Models\User;
use App\Services\AcademicYearService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SuperAdminKelasImport implements ToModel, WithHeadingRow
{
    use Importable;

    public function model(array $row)
    {
        try {
            DB::beginTransaction();

            $prodi = ProgramStudi::where('name', $row['program_studi'])->first();
            if (!$prodi) {
                return null;
            }

            $course = Course::firstOrCreate([
                'code' => $row['kode_mata_kuliah'],
                'name' => $row['nama_mata_kuliah'],
                'credit' => $row['sks'],
                'program_studi_id' => $prodi->id,
            ]);

            $course->save();


            $tahunAkademik = AcademicYear::where('name', $row['tahun_akademik'])
                ->where('semester', $row['semester'])
                ->first();


            $dosen = User::where('name', $row['nama_dosen'])->first();

            $kelas = ClassRoom::firstOrNew([
                'id' => $row['kode'],
            ]);

            $kelas->fill([
                'course_id' => $course->id,
                'lecturer_id' => $dosen?->lecturer?->id ?? null,
                'name' => $row['nama'],
                'academic_year_id' => $tahunAkademik?->id ?? app(AcademicYearService::class)->getCurrentAcademicYear()->id,
            ]);

            $kelas->save();

            DB::commit();

            return $kelas;
        } catch (\Throwable $th) {
            DB::rollBack();

            return null;
        }
    }
}
