<?php

namespace App\Services;

use App\Models\Course;
use Illuminate\Support\Facades\DB;

class MataKuliahService
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
            $mataKuliah = Course::create($validated);

            return $mataKuliah;
        });
    }


    public function update($id, $validated)
    {
        return DB::transaction(function () use ($id, $validated) {
            $mataKuliah = Course::findOrFail($id);
            $mataKuliah->update($validated);

            return $mataKuliah;
        });
    }

    public  function delete($id)
    {
        return DB::transaction(function () use ($id) {
            $mataKuliah = Course::findOrFail($id);
            $mataKuliah->delete();

            return $mataKuliah;
        });
    }
}
