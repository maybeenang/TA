<?php

namespace App\Services;

use App\Enums\RolesEnum;
use App\Models\AcademicYear;
use App\Models\ClassRoom;
use App\Models\Course;
use App\Models\Fakultas;
use App\Models\Lecturer;
use App\Models\ProgramStudi;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ScraperService
{
    protected AcademicYearService $academicYearService;
    protected KelasService $kelasService;

    public function __construct()
    {
        $this->academicYearService = app(AcademicYearService::class);
        $this->kelasService = app(KelasService::class);
    }


    public function scrapeAll()
    {
        try {

            $response = Http::timeout(-1)->get('http://localhost:3000/tahun-ajaran');
            $datas = $response->json('data');

            DB::transaction(function () use ($datas) {
                foreach ($datas as $data) {

                    $startDate = match ($data['semester']) {
                        'Ganjil' => $data['tahunAwal'] . '-09-01',
                        'Genap' => $data['tahunAkhir'] . '-01-01',
                        'Pendek' => $data['tahunAkhir'] . '-06-01',
                        default => '2025-01-01',
                    };


                    $endDate = match ($data['semester']) {
                        'Ganjil' => $data['tahunAwal'] . '-12-31',
                        'Genap' => $data['tahunAkhir'] . '-05-31',
                        'Pendek' => $data['tahunAkhir'] . '-08-31',
                        default => '2025-12-31',
                    };

                    AcademicYear::upsert(
                        [
                            'id' => $data['id'],
                            'name' => $data['name'],
                            'semester' => $data['semester'],
                            'start_date' => $startDate,
                            'end_date' => $endDate,
                        ],
                        uniqueBy: ['id'],
                        update: ['name', 'semester']
                    );
                }
            });

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


            $response = Http::timeout(-1)->get('http://localhost:3000/dosen');
            $datas = $response->json('data');

            DB::transaction(function () use ($datas) {
                $prodi = ProgramStudi::query()
                    ->select('id')
                    ->where('name', 'like', '%' . "Teknik Informatika" . '%')->first();
                foreach ($datas as $data) {

                    User::upsert(
                        [
                            'name' => $data['nama'],
                            'email' => $data['email'],
                            'password' => bcrypt('password'),
                            'program_studi_id' => $prodi->id,
                        ],
                        uniqueBy: ['email'],
                        update: ['name', 'email', 'password', 'program_studi_id']
                    );

                    $user = User::where('email', $data['email'])->first();
                    $user->assignRole(RolesEnum::TENAGAPENGAJAR->value);

                    $nip = $data['nip'] === "" ? fake()->unique()->numerify('##########') : $data['nip'];

                    Lecturer::upsert(
                        [
                            'nip' => $nip,
                            'user_id' => $user->id,
                        ],
                        uniqueBy: ['nip'],
                        update: ['nip', 'user_id']
                    );
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

                    $tahunAjaranSekarang = $this->academicYearService->getCurrentAcademicYear();

                    $foundClassroom = ClassRoom::query()
                        ->where('name', $item['nama'])
                        ->where('course_id', Course::where('code', $item['kodeMk'])->first()->id)
                        ->first();


                    if (!$foundClassroom) {
                        ClassRoom::create([
                            'id' => $item['kode'],
                            'name' => $item['nama'],
                            'course_id' => Course::where('code', $item['kodeMk'])->first()->id,
                            'academic_year_id' => $tahunAjaranSekarang?->id ?? 20241,
                        ]);
                    } else {
                        $foundClassroom->update([
                            'id' => $item['kode'],
                            'name' => $item['nama'],
                            'course_id' => Course::where('code', $item['kodeMk'])->first()->id,
                            'academic_year_id' => $tahunAjaranSekarang?->id ?? 20241,
                        ]);
                    }
                }
            });

            return $datas;
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    public function screpaKelas($id)
    {

        try {

            $response = Http::timeout(-1)->get('http://localhost:3000/kelas/' . $id);
            $data = $response->json('data');
            $mahasiswas = $data['mahasiswa'];
            $dosen = $data['dosen'];

            // hilangkan semua titik dan koma
            $namaDosen = strtolower($dosen);

            // ambil 2 kata pertama
            $namaDosen = explode(' ', $namaDosen);
            $namaDosen = $namaDosen[0] . ' ' . $namaDosen[1];

            $namaDosen = preg_replace('/[^a-zA-Z0-9]+$/', '', $namaDosen);

            $lecturer = Lecturer::whereHas('user', function ($query) use ($namaDosen) {
                $query->whereRaw('LOWER(name) like ?', ["%$namaDosen%"]);
            })->first();

            if ($lecturer) {
                $classroom = ClassRoom::where('id', $id)->first();
                $classroom->lecturer_id = $lecturer->id;
                $classroom->save();
            }


            DB::transaction(function () use ($mahasiswas, $id) {
                foreach ($mahasiswas as $mahasiswa) {
                    Student::upsert(
                        [
                            'nim' => $mahasiswa['nim'],
                            'name' => $mahasiswa['name'],
                            'program_studi_id' => ProgramStudi::where('name', 'like', '%' . "Teknik Informatika" . '%')->first()->id,
                        ],
                        uniqueBy: ['nim'],
                        update: ['name']
                    );
                }

                $classroom = ClassRoom::where('id', $id)->first();

                $students = Student::whereIn('nim', array_map(function ($mahasiswa) {
                    return $mahasiswa['nim'];
                }, $mahasiswas))->get();

                // get all student id to array
                $studentIds = $students->map(function ($student) {
                    return $student->id;
                })->toArray();

                $this->kelasService->addStudentClassroom($classroom, $studentIds);
            });

            return $data;
        } catch (\Throwable $th) {

            throw $th;
        }
    }
}
