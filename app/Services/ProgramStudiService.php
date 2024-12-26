<?php

namespace App\Services;

use App\Models\ProgramStudi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ProgramStudiService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * @return mixed
     * @param mixed $validated
     */
    public function create($validated)
    {
        return DB::transaction(function () use ($validated) {
            $programStudi = ProgramStudi::create($validated);

            return $programStudi;
        });
    }
    /**
     * @return mixed
     * @param mixed $id
     * @param mixed $validated
     */
    public function update($id, $validated)
    {
        return DB::transaction(function () use ($id, $validated) {
            $programStudi = ProgramStudi::findOrFail($id);
            $programStudi->update($validated);

            return $programStudi;
        });
    }

    /**
     * @return mixed
     * @param mixed $id
     */
    public  function delete($id)
    {
        return DB::transaction(function () use ($id) {
            $programStudi = ProgramStudi::findOrFail($id);
            $programStudi->delete();

            return $programStudi;
        });
    }
    /**
     * @return void
     */
    public function scrapeData(): void
    {
        DB::transaction(function () {
            $response = Http::get('http://localhost:3000/prodi');
            $data = $response->json('data');

            foreach ($data as $item) {
                ProgramStudi::updateOrCreate(
                    ['name' => $item],
                    ['name' => $item]
                );
            }

            return $data;
        });
    }
}
