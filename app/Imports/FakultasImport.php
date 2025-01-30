<?php

namespace App\Imports;

use App\Models\Fakultas;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class FakultasImport implements ToModel, WithHeadingRow
{
    use Importable;

    public function model(array $row)
    {
        try {
            DB::beginTransaction();

            $fakultas =  Fakultas::firstOrNew([
                'name' => $row['nama']
            ]);

            $fakultas->save();

            DB::commit();

            return $fakultas;
        } catch (\Throwable $th) {
            DB::rollBack();

            return null;
        }
    }
}
