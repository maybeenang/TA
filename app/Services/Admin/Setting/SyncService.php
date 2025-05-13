<?php

namespace App\Services\Admin\Setting;

use App\Enums\RolesEnum;
use App\Models\Lecturer;
use App\Models\User;
use App\Services\AcademicYearService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class SyncService
{
    protected $baseUrl;
    protected $timeout = 0; // Unlimited timeout

    public function __construct()
    {
        $this->baseUrl = Config::get('app.sync_api_endpoint.url');

        if (empty($this->baseUrl)) {
            throw new Exception('Sync API endpoint is not configured');
        }
    }

    public function sync($type)
    {
        switch ($type) {
            case 'kelas':
                return $this->getKelas();
            case 'pengguna':
                return $this->getDosen();
            case 'tahun_akademik':
                return $this->getTahunAjaran();
            case 'prodi':
                return $this->getProgramStudi();
            case 'fakultas':
                return $this->getFakultas();
            case 'fakultas_prodi':
                return $this->getFakultasProdi();
            case 'mata_kuliah':
                return $this->getMataKuliah();
            case 'mahasiswa':
                return $this->getMahasiswa();
            default:
                throw new Exception('Invalid sync type');
        }
    }

    public function getMataKuliah() {}


    public function getMahasiswa()
    {

        // get all ids kelas, and split into chunk of 20
        $ids = \App\Models\ClassRoom::where('academic_year_id', app(AcademicYearService::class)->getCurrentAcademicYear()?->id)
            ->whereHas('course', function ($query) {
                $query->where('program_studi_id', Auth::user()->programStudi?->id);
            })
            ->pluck('id')
            ->toArray();

        $chunks = array_chunk($ids, 20);

        $datas = [];

        foreach ($chunks as $chunk) {
            $data = $this->getKelasByIDs($chunk);
            if (!$data['success']) {
                continue;
            }
            $datas = array_merge($datas, $data['data']);
        }

        if (empty($datas)) {
            throw new Exception('Failed to fetch mahasiswa data');
        }

        // make chunk of 10 datas
        $chunks = array_chunk($datas, 10);

        foreach ($chunks as $chunk) {
            $this->createOrUpdateMahasiswa($chunk);
        }

        return [
            'message' => 'Sinkronasi mahasiswa berhasil',
        ];
    }

    public function createOrUpdateMahasiswa(array $data)
    {
        try {
            DB::transaction(function () use ($data) {
                foreach ($data as $item) {
                    $foundKelas = \App\Models\ClassRoom::where('id', $item['id'])->first();

                    if (!$foundKelas) {
                        continue;
                    }

                    if ($item['dosen']) {
                        $dosen = User::where('name', $item['dosen'])->first();
                        $lecturer = $dosen?->lecturer;

                        if ($lecturer) {
                            $foundKelas->update([
                                'lecturer_id' => $lecturer->id,
                            ]);
                        }
                    }

                    foreach ($item['mahasiswa'] as $mahasiswa) {
                        $foundMahasiswa = \App\Models\Student::where('nim', $mahasiswa['nim'])->first();
                        if (!$foundMahasiswa) {
                            // createa mahasiswa
                            $mahasiswa = \App\Models\Student::create([
                                'nim' => preg_replace('/\s+/', '', $mahasiswa['nim']) ?: fake()->unique()->randomNumber(9),
                                'name' => $mahasiswa['name'],
                                'program_studi_id' => Auth::user()->programStudi?->id,
                            ]);
                            $foundMahasiswa = $mahasiswa;
                        } else {
                            $foundMahasiswa->update([
                                'nim' => preg_replace('/\s+/', '', $mahasiswa['nim']) ?: fake()->unique()->randomNumber(9),
                                'name' => $mahasiswa['name'],
                            ]);
                        }

                        $foundStudentClassroom = \App\Models\StudentClassroom::where('student_id', $foundMahasiswa->id)
                            ->where('class_room_id', $foundKelas->id)
                            ->first();

                        if (!$foundStudentClassroom) {
                            // create student classroom
                            \App\Models\StudentClassroom::create([
                                'student_id' => $foundMahasiswa->id,
                                'class_room_id' => $foundKelas->id,
                            ]);
                        } else {
                            // update student classroom
                            $foundStudentClassroom->update([
                                'student_id' => $foundMahasiswa->id,
                                'class_room_id' => $foundKelas->id,
                            ]);
                        }
                    }

                    Log::info('Synced mahasiswa: ' . $item['id'], [
                        'dosen' => $item['dosen'],
                    ]);
                }
            });

            return true;
        } catch (\Throwable $th) {
            Log::error('Error syncing mahasiswa: ' . $th->getMessage(), [
                'data' => $data,
                'trace' => $th->getTraceAsString()
            ]);

            throw $th;
        }
    }

    /**
     * Get program studi data
     *
     * @return array
     */
    public function getProgramStudi()
    {
        return $this->get('/prodi');
    }

    /**
     * Get fakultas data
     *
     * @return array
     */
    public function getFakultas()
    {
        return $this->get('/fakultas');
    }

    /**
     * Get fakultas-prodi relation data
     *
     * @return array
     */
    public function getFakultasProdi()
    {
        return $this->get('/fakultas-prodi');
    }

    /**
     * Get all class data
     *
     * @return array
     */
    public function getKelas()
    {
        $data = $this->get('/kelas');
        if (!$data['success']) {
            throw new Exception('Failed to fetch class data');
        }

        $this->createOrUpdateKelas($data['data']);

        return [
            'message' => 'Sinkronasi kelas berhasil',
        ];
    }

    public function checkMkIf(string $kodeMK)
    {
        // check if kodeMK starter with 'IF'
        if (str_starts_with($kodeMK, 'IF')) {
            return true;
        }
        return false;
    }


    public function createOrUpdateKelas(array $kelas)
    {
        DB::beginTransaction();

        try {
            foreach ($kelas as $item) {
                $validMk = $this->checkMkIf($item['kodeMk']);
                if (!$validMk) {
                    continue;
                }

                // check apakah ada matakuliah dengan kode mk yang sama
                $foundMk = \App\Models\Course::where('code', $item['kodeMk'])->first();
                if (!$foundMk) {
                    // Jika matakuliah tidak ada, buat baru
                    $mk = \App\Models\Course::create([
                        'code' => $item['kodeMk'],
                        'name' => $item['namaMk'],
                        'credit' => $item['sks'],
                        'program_studi_id' => Auth::user()->programStudi?->id,
                    ]);
                    $foundMk = $mk;
                } else {
                    // update matakuliah
                    $foundMk->update([
                        'code' => $item['kodeMk'],
                        'name' => $item['namaMk'],
                        'credit' => $item['sks'],
                    ]);
                }

                // buat atau update kelas
                \App\Models\ClassRoom::updateOrCreate(
                    [
                        'id' => $item['kode'],
                        'course_id' => $foundMk->id,
                    ],
                    [
                        'name' => $item['nama'],
                        'academic_year_id' => app(AcademicYearService::class)->getCurrentAcademicYear()?->id,
                    ]
                );

                Log::info('Synced class: ' . $item['kode']);
            }

            DB::commit();

            return true;
        } catch (Exception $e) {
            // Rollback transaction on error
            DB::rollBack();

            Log::error('Error syncing classes: ' . $e->getMessage(), [
                'data' => $kelas,
                'trace' => $e->getTraceAsString()
            ]);

            throw $e;
        }
    }

    /**
     * Get specific class data
     *
     * @param int $id
     * @return array
     */
    public function getKelasByID($id)
    {
        return $this->get('/kelas/' . $id);
    }

    /**
     * Get lecturers data
     *
     * @return array
     */
    public function getDosen()
    {
        $data = $this->get('/dosen');

        if (!$data['success']) {
            throw new Exception('Failed to fetch lecturers data');
        }

        $this->createOrUpdatePengguna($data['data']);

        return [
            'message' => 'Sinkronasi pengguna berhasil',
        ];
    }

    public function createOrUpdatePengguna(array $data)
    {
        DB::beginTransaction();

        try {
            $programStudi = Auth::user()->programStudi;
            $role = Role::findOrCreate(RolesEnum::TENAGAPENGAJAR->value, 'web');
            foreach ($data as $item) {

                if ($item['nip'] == null || $item['nip'] == '') {
                    continue;
                }

                $nip = preg_replace('/\s+/', '', $item['nip']);

                $foundDosen = Lecturer::where('nip', $nip)->first();

                if (!$foundDosen || $foundDosen == null) {
                    // Jika dosen tidak ada, buat baru
                    $user = User::create([
                        'name' => $item['nama'],
                        'email' => $item['email'],
                        'password' => bcrypt('password'),
                        'email_verified_at' => now(),
                        'program_studi_id' => $programStudi?->id,
                    ]);

                    $user->assignRole($role);

                    $user->lecturer()->create([
                        'nip' => preg_replace('/\s+/', '', $item['nip']) ?: fake()->unique()->randomNumber(9),
                    ]);
                }


                // update user data
                $foundDosen->update([
                    'nip' => preg_replace('/\s+/', '', $item['nip']) ?: fake()->unique()->randomNumber(9),
                ]);

                $foundDosen->user()->update([
                    'name' => $item['nama'],
                    'email' => $item['email'],
                    'program_studi_id' => $programStudi?->id,
                ]);
            }

            DB::commit();

            return true;
        } catch (Exception $e) {
            // Rollback transaction on error
            DB::rollBack();

            Log::error('Error syncing users: ' . $e->getMessage(), [
                'data' => $data,
                'trace' => $e->getTraceAsString()
            ]);

            throw $e;
        }
    }


    /**
     * Get all academic years
     *
     * @return array
     */
    public function getTahunAjaran()
    {
        $data  = $this->get('/tahun-ajaran');

        if (!$data['success']) {
            throw new Exception('Failed to fetch academic years');
        }

        $this->createOrUpdateTahunAjaran($data['data']);

        return [
            'message' => 'Sinkronasi tahun akademik berhasil',
        ];
    }

    /**
     * Create or update academic year data
     *
     * @param array $data
     * @return void
     */
    public function createOrUpdateTahunAjaran(array $data)
    {
        DB::beginTransaction();

        try {
            foreach ($data as $item) {
                // Parse tanggal mulai dan selesai tahun akademik
                $startDate = null;
                $endDate = null;

                if (!empty($item['tahunAwal']) && !empty($item['semester'])) {
                    // Untuk semester Ganjil: Agustus - Januari
                    switch ($item['semester']) {
                        case 'Ganjil':
                            $startDate = date('Y-m-d', strtotime($item['tahunAwal'] . '-09-01'));
                            $endDate = date('Y-m-d', strtotime($item['tahunAwal'] . '-12-31'));
                            break;
                        case 'Genap':
                            $startDate = date('Y-m-d', strtotime($item['tahunAkhir'] . '-01-01'));
                            $endDate = date('Y-m-d', strtotime($item['tahunAkhir'] . '-05-31'));
                            break;
                        case 'Pendek':
                            $startDate = date('Y-m-d', strtotime($item['tahunAkhir'] . '-06-01'));
                            $endDate = date('Y-m-d', strtotime($item['tahunAkhir'] . '-08-31'));
                            break;
                    }
                }

                // Cari tahun akademik berdasarkan ID atau buat baru jika tidak ada
                \App\Models\AcademicYear::updateOrCreate(
                    [
                        'id' => $item['id'] // ID dari API sebagai lookup key
                    ],
                    [
                        'name' => $item['name'], // Format: 2025/2026
                        'semester' => $item['semester'], // Ganjil atau Genap
                        'start_date' => $startDate,
                        'end_date' => $endDate,
                    ]
                );

                // Log aktivitas sinkronisasi
                Log::info('Synced academic year: ' . $item['fullName']);
            }

            // Commit transaction
            DB::commit();

            return true;
        } catch (Exception $e) {
            // Rollback transaction on error
            DB::rollBack();

            Log::error('Error syncing academic years: ' . $e->getMessage(), [
                'data' => $data,
                'trace' => $e->getTraceAsString()
            ]);

            throw $e;
        }
    }

    /**
     * Get specific academic year
     *
     * @param int $id
     * @return array
     */
    public function getTahunAjaranByID($id)
    {
        return $this->get('/tahun-ajaran/' . $id);
    }

    /**
     * Get specified class data by IDs
     *
     * @param array $ids
     * @return array
     */
    public function getKelasByIDs(array $ids)
    {
        return $this->post('/kelas', [
            'ids' => $ids
        ]);
    }

    /**
     * Perform a GET request
     *
     * @param string $endpoint
     * @return array
     */
    protected function get($endpoint)
    {
        try {
            $response = Http::timeout($this->timeout)
                ->get($this->baseUrl . $endpoint);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $response->json('data') ?? $response->json()
                ];
            }

            Log::error('Sync API error', [
                'endpoint' => $endpoint,
                'status' => $response->status(),
                'response' => $response->body()
            ]);

            return [
                'success' => false,
                'message' => 'Failed to fetch data: ' . $response->status(),
                'data' => []
            ];
        } catch (Exception $e) {
            Log::error('Sync API exception', [
                'endpoint' => $endpoint,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }

    /**
     * Perform a POST request
     *
     * @param string $endpoint
     * @param array $data
     * @return array
     */
    protected function post($endpoint, array $data)
    {
        try {
            $response = Http::timeout($this->timeout)
                ->post($this->baseUrl . $endpoint, $data);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $response->json('data') ?? $response->json()
                ];
            }

            Log::error('Sync API error', [
                'endpoint' => $endpoint,
                'data' => $data,
                'status' => $response->status(),
                'response' => $response->body()
            ]);

            return [
                'success' => false,
                'message' => 'Failed to post data: ' . $response->status(),
                'data' => []
            ];
        } catch (Exception $e) {
            Log::error('Sync API exception', [
                'endpoint' => $endpoint,
                'data' => $data,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }

    /**
     * Parse class data for import
     *
     * @param array $classData
     * @return array
     */
    public function parseKelasData(array $classData)
    {
        $result = [];

        foreach ($classData as $kelas) {
            $result[] = [
                'kode' => $kelas['kode'],
                'nama' => $kelas['nama'],
                'kode_mk' => $kelas['kodeMk'],
                'nama_mk' => $kelas['namaMk'],
                'sks' => $kelas['sks']
            ];
        }

        return $result;
    }
}
