<?php

namespace App\Services;

use App\Models\ClassRoom;
use App\Models\Course;
use App\Models\Fakultas;
use App\Models\ProgramStudi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ScraperService
{
    public function scrapeAll()
    {
        try {
            $response = Http::timeout(-1)->get('http://localhost:3000/fakultas-prodi');
            $datas = $response->json('data');

            DB::transaction(function () use ($datas) {
                foreach ($datas as $data) {
                    Fakultas::upsert(
                        ['name' => $data['fakultas']],
                        uniqueBy: ['name'],
                        update: ['created_at', 'updated_at']
                    );

                    $fakultas = Fakultas::where('name', $data['fakultas'])->first();

                    foreach ($data['prodi'] as $prodi) {
                        ProgramStudi::upsert(
                            ['name' => $prodi, 'fakultas_id' => $fakultas->id],
                            uniqueBy: ['name'],
                            update: ['created_at', 'updated_at']
                        );
                    }
                }
            });

            // scrape kelas dan mata kuliah
            $response = Http::timeout(-1)->get('http://localhost:3000/kelas');
            $datas = $response->json('data');

            DB::transaction(function () use ($datas) {
                $if = ProgramStudi::query()
                    ->select('id')
                    ->where('name', 'like', '%' . "Teknik Informatika" . '%')->first();

                foreach ($datas as $item) {

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
                            'id' => $item['kode'],
                            'name' => $item['nama'],
                            'course_id' => Course::where('code', $item['kodeMk'])->first()->id,
                            'academic_year_id' => 1,
                        ]);
                    } else {
                        $foundClassroom->update([
                            'id' => $item['kode'],
                            'name' => $item['nama'],
                            'course_id' => Course::where('code', $item['kodeMk'])->first()->id,
                            'academic_year_id' => 1,
                        ]);
                    }
                }
            });

            return $datas;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
