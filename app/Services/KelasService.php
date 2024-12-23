<?php

namespace App\Services;

use App\Models\ClassRoom;
use App\Models\Course;
use App\Models\ProgramStudi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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

    public function scrapeData()
    {
        DB::transaction(function () {
            $response = Http::timeout(-1)->get('http://localhost:3000/kelas');
            $data = $response->json('data');

            $if = ProgramStudi::query()
                ->select('id')
                ->where('name', 'like', '%' . "Teknik Informatika" . '%')->first();

            foreach ($data as $item) {
                // cek apakah kodeMK mengandung kata IF
                if (strpos($item['kodeMk'], 'IF') === false) {
                    continue;
                }

                Course::upsert(
                    [
                        'name' => $item['namaMk'],
                        'code' => $item['kodeMk'],
                        'credit' => $item['sks'],
                        'program_studi_id' => $if->id,
                    ],
                    uniqueBy: ['code'],
                    update: ['name', 'code', 'program_studi_id', 'credit']
                );

                $foundClassroom = ClassRoom::query()
                    ->where('name', $item['nama'])
                    ->where('course_id', Course::where('code', $item['kodeMk'])->first()->id)
                    ->first();

                if (!$foundClassroom) {
                    ClassRoom::create([
                        'name' => $item['nama'],
                        'course_id' => Course::where('code', $item['kodeMk'])->first()->id,
                        'academic_year_id' => 1,
                    ]);
                }


                /*ClassRoom::upsert(*/
                /*    [*/
                /*        'name' => $item['nama'],*/
                /*        'course_id' => Course::where('code', $item['kodeMk'])->first()->id,*/
                /*        'academic_year_id' => 1,*/
                /*    ],*/
                /*    uniqueBy: ['name', 'course_id'],*/
                /*    update: ['course_id', 'academic_year_id', 'name']*/
                /*);*/
            }

            return $data;
        });
    }


    public function getAllClassrooms()
    {
        return ClassRoom::all();
    }
}
