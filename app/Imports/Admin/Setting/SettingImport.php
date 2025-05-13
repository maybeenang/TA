<?php

namespace App\Imports\Admin\Setting;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use Illuminate\Support\Facades\Log;

class SettingImport extends DefaultValueBinder implements ToCollection, WithHeadingRow, WithValidation, WithCustomValueBinder
{
    use Importable;

    protected $type;
    protected $programStudiId;
    protected $handler;

    public function __construct(string $type, int $programStudiId, callable $handler = null)
    {
        $this->type = $type;
        $this->programStudiId = $programStudiId;
        $this->handler = $handler;
    }

    public function bindValue(Cell $cell, $value)
    {
        // Pastikan nilai NIM, kode, dan ID selalu sebagai string
        if (is_numeric($value) && strlen($value) > 7) {
            $cell->setValueExplicit((string) $value);
            return true;
        }

        return parent::bindValue($cell, $value);
    }

    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        if ($rows->isEmpty()) {
            throw new \Exception('File import kosong atau tidak berformat yang sesuai');
        }

        // Log jumlah data yang diimport
        Log::info("Importing {$this->type} data", ['count' => $rows->count()]);

        if ($this->handler) {
            // Panggil handler callback yang diberikan saat construct
            call_user_func($this->handler, $rows, $this->programStudiId);
        } else {
            // Jika tidak ada handler khusus, gunakan metode default berdasarkan tipe
            $this->processImport($rows);
        }
    }

    /**
     * Process import based on type
     *
     * @param Collection $rows
     * @return void
     */
    protected function processImport(Collection $rows)
    {
        switch ($this->type) {
            case 'tahun_akademik':
                $this->importTahunAkademik($rows);
                break;
            case 'mahasiswa':
                $this->importMahasiswa($rows);
                break;
            case 'mata_kuliah':
                $this->importMataKuliah($rows);
                break;
            case 'kelas':
                $this->importKelas($rows);
                break;
            case 'pengguna':
                $this->importPengguna($rows);
                break;
            default:
                throw new \Exception("Tipe import '{$this->type}' tidak didukung");
        }
    }

    /**
     * Import Tahun Akademik
     *
     * @param Collection $rows
     * @return void
     */
    protected function importTahunAkademik(Collection $rows)
    {
        foreach ($rows as $row) {
            \App\Models\AcademicYear::updateOrCreate(
                ['id' => $row['id']],
                [
                    'name' => $row['tahun_akademik'],
                    'semester' => $row['semester'],
                    'start_date' => $row['tanggal_mulai'],
                    'end_date' => $row['tanggal_selesai']
                ]
            );
        }
    }

    /**
     * Import Mahasiswa
     *
     * @param Collection $rows
     * @return void
     */
    protected function importMahasiswa(Collection $rows)
    {
        foreach ($rows as $row) {
            \App\Models\Student::updateOrCreate(
                ['nim' => $row['nim']],
                [
                    'name' => $row['nama'],
                    'program_studi_id' => $this->programStudiId
                ]
            );
        }
    }

    /**
     * Import Mata Kuliah
     *
     * @param Collection $rows
     * @return void
     */
    protected function importMataKuliah(Collection $rows)
    {
        foreach ($rows as $row) {
            \App\Models\Course::updateOrCreate(
                ['code' => $row['kode']],
                [
                    'name' => $row['nama'],
                    'credit' => $row['sks'],
                    'program_studi_id' => $this->programStudiId
                ]
            );
        }
    }

    /**
     * Import Kelas
     *
     * @param Collection $rows
     * @return void
     */
    protected function importKelas(Collection $rows)
    {
        foreach ($rows as $row) {
            // Cari mata kuliah terlebih dahulu
            $course = \App\Models\Course::where('code', $row['kode_mata_kuliah'])->first();

            if (!$course) {
                Log::warning("Mata kuliah dengan kode {$row['kode_mata_kuliah']} tidak ditemukan");
                continue;
            }

            // Cari dosen berdasarkan nama
            $lecturer = null;
            if (!empty($row['dosen'])) {
                $lecturer = \App\Models\Lecturer::whereHas('user', function ($query) use ($row) {
                    $query->where('name', $row['dosen']);
                })->first();
            }

            // Cari tahun akademik berdasarkan nama dan semester
            $academicYear = null;
            if (!empty($row['tahun_akademik'])) {
                $academicYear = \App\Models\AcademicYear::where('full_name', $row['tahun_akademik'])
                    ->orWhere('name', $row['tahun_akademik'])
                    ->first();
            }

            \App\Models\ClassRoom::updateOrCreate(
                ['id' => $row['kode_kelas']],
                [
                    'name' => $row['kelas'],
                    'course_id' => $course->id,
                    'lecturer_id' => $lecturer ? $lecturer->id : null,
                    'academic_year_id' => $academicYear ? $academicYear->id : null
                ]
            );
        }
    }

    /**
     * Import Pengguna
     *
     * @param Collection $rows
     * @return void
     */
    protected function importPengguna(Collection $rows)
    {
        foreach ($rows as $row) {
            // Buat atau update user
            $user = \App\Models\User::updateOrCreate(
                ['email' => $row['email']],
                [
                    'name' => $row['nama'],
                    'program_studi_id' => $this->programStudiId,
                ]
            );

            // Buat atau update dosen
            if (!empty($row['nip'])) {
                \App\Models\Lecturer::updateOrCreate(
                    ['user_id' => $user->id],
                    ['nip' => $row['nip']]
                );

                // Pastikan user memiliki role tenaga pengajar
                if (!$user->hasRole('tenaga-pengajar')) {
                    $user->assignRole('tenaga-pengajar');
                }
            }
        }
    }

    /**
     * Get validation rules
     *
     * @return array
     */
    public function rules(): array
    {
        switch ($this->type) {
            case 'tahun_akademik':
                return [
                    '*.id' => 'required',
                    '*.tahun_akademik' => 'required',
                    '*.semester' => 'required',
                ];
            case 'mahasiswa':
                return [
                    '*.nim' => 'required',
                    '*.nama' => 'required',
                ];
            case 'mata_kuliah':
                return [
                    '*.kode' => 'required',
                    '*.nama' => 'required',
                    '*.sks' => 'required|numeric',
                ];
            case 'kelas':
                return [
                    '*.kode_kelas' => 'required',
                    '*.kode_mata_kuliah' => 'required',
                    '*.kelas' => 'required',
                ];
            case 'pengguna':
                return [
                    '*.nama' => 'required',
                    '*.email' => 'required|email',
                ];
            default:
                return [];
        }
    }
}
