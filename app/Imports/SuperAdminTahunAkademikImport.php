<?php

namespace App\Imports;

use App\Models\AcademicYear;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SuperAdminTahunAkademikImport implements ToModel, WithHeadingRow
{
    use Importable;

    public function model(array $row)
    {
        try {
            DB::beginTransaction();

            $tahunAkademik = AcademicYear::firstOrCreate([
                'name' => $row['nama'],
                'semester' => $row['semester'],
                'start_date' => $row['tanggal_mulai'],
                'end_date' => $row['tanggal_selesai']
            ]);

            DB::commit();

            return $tahunAkademik;
        } catch (\Throwable $th) {
            DB::rollBack();

            return null;
        }
    }
}
