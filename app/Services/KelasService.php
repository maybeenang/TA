<?php

namespace App\Services;

use App\Models\ClassRoom;
use Illuminate\Support\Facades\DB;

class KelasService
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
            $kelas = ClassRoom::create($validated);

            return $kelas;
        });
    }

    public function update($id, $validated)
    {
        return DB::transaction(function () use ($id, $validated) {
            $kelas = ClassRoom::findOrFail($id);
            $kelas->update($validated);

            return $kelas;
        });
    }

    public  function delete($id)
    {
        return DB::transaction(function () use ($id) {
            $kelas = ClassRoom::findOrFail($id);
            $kelas->delete();

            return $kelas;
        });
    }
}
