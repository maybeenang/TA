<?php

namespace App\Imports;

use App\Models\Fakultas;
use App\Models\ProgramStudi;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProdiImport implements ToModel, WithHeadingRow
{
    use Importable;

    public function model(array $row)
    {
        try {
            DB::beginTransaction();
            $fakultas =  Fakultas::firstOrNew([
                'name' => $row['fakultas']
            ]);

            $fakultas->save();

            $prodi = ProgramStudi::firstOrNew([
                'name' => $row['nama'],
                'fakultas_id' => $fakultas->id
            ]);

            $prodi->save();

            DB::commit();

            return $prodi;
        } catch (\Throwable $th) {
            DB::rollBack();
            return null;
        }
    }
}
