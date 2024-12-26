<?php

namespace App\Services;

use App\Models\Fakultas;
use Illuminate\Support\Facades\DB;

class FakultasSerivce
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function create($validated)
    {
        return DB::transaction(function () use ($validated) {
            $fakultas = Fakultas::create($validated);

            return $fakultas;
        });
    }

    public function update($fakultas, $validated)
    {
        return DB::transaction(function () use ($fakultas, $validated) {
            $fakultas->update($validated);

            return $fakultas;
        });
    }

    public  function delete($fakultas)
    {
        return DB::transaction(function () use ($fakultas) {
            $fakultas->delete();

            return $fakultas;
        });
    }
}
