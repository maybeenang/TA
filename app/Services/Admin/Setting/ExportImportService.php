<?php

namespace App\Services\Admin\Setting;

use App\Models\Setting;
use App\Models\AcademicYear;
use App\Models\Student;
use App\Models\Course;
use App\Models\ClassRoom;
use App\Exports\Admin\Setting\ExportData;
use App\Imports\Admin\Setting\SettingImport;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\UploadedFile;
use Maatwebsite\Excel\Facades\Excel;
use Exception;
use Illuminate\Support\Facades\DB;

class ExportImportService
{
    /**
     * Export data ke file
     */
    public function export(string $type, int $programStudiId)
    {
        try {
            // Ambil data dari cache jika ada
            $data = $this->getDataForExport($type, $programStudiId);

            // Konfigurasi export berdasarkan tipe
            $config = $this->getExportConfig($type);

            // Export ke Excel
            $result = (new ExportData($data, $config['headers'], $config['mapping']));

            // Update last export time
            /* $this->updateLastExportTime($type, $programStudiId); */

            return $result;
        } catch (\Exception $e) {
            Log::error("Export failed: {$e->getMessage()}", [
                'type' => $type,
                'program_studi_id' => $programStudiId,
                'error' => $e
            ]);

            throw new \Exception('Export failed. Please try again later.');
        }
    }

    /**
     * Import data dari file
     *
     * @param string $type
     * @param int $programStudiId
     * @param UploadedFile $file
     * @return array
     */
    public function import(string $type, int $programStudiId, UploadedFile $file)
    {
        try {
            DB::beginTransaction();

            // Normalisasi tipe untuk menyesuaikan dengan konfigurasi
            $normalizedType = str_replace('-', '_', $type);

            // Cek jika tipe didukung
            $this->getExportConfig($normalizedType);

            // Import data dari file Excel
            Excel::import(new SettingImport($normalizedType, $programStudiId), $file);

            // Update last import time
            /* $this->updateLastImportTime($normalizedType, $programStudiId); */

            DB::commit();

            return [
                'success' => true,
                'message' => 'Import berhasil'
            ];
        } catch (Exception $e) {
            DB::rollBack();

            Log::error("Import failed: {$e->getMessage()}", [
                'type' => $type,
                'program_studi_id' => $programStudiId,
                'error' => $e
            ]);

            return [
                'success' => false,
                'message' => 'Import gagal: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Create template file for import
     *
     * @param string $type
     * @param int $programStudiId
     * @return ExportData
     */
    public function createImportTemplate(string $type)
    {
        try {
            // Normalisasi tipe untuk menyesuaikan dengan konfigurasi
            $normalizedType = str_replace('-', '_', $type);

            // Dapatkan konfigurasi untuk tipe data
            $config = $this->getExportConfig($normalizedType);

            // Buat koleksi kosong
            $data = collect([]);

            // Export ke Excel
            return new ExportData($data, $config['headers'], $config['mapping']);
        } catch (Exception $e) {
            Log::error("Template creation failed: {$e->getMessage()}", [
                'type' => $type,
                'error' => $e
            ]);

            throw new Exception('Gagal membuat template import: ' . $e->getMessage());
        }
    }

    /**
     * Get export configuration
     */
    private function getExportConfig(string $type): array
    {
        $configs = [
            'tahun_akademik' => [
                'headers' => ['ID', 'Tahun Akademik', 'Semester', 'Tanggal Mulai', 'Tanggal Selesai'],
                'mapping' => [
                    'id',
                    'name',
                    'semester',
                    'start_date',
                    'end_date'
                ]
            ],
            'mahasiswa' => [
                'headers' => ['NIM', 'Nama'],
                'mapping' => [
                    'nim',
                    'name',
                ]
            ],
            'mata_kuliah' => [
                'headers' => ['Kode', 'Nama', 'SKS', 'Program Studi'],
                'mapping' => [
                    'code',
                    'name',
                    'credit',
                    function ($course) {
                        return $course->programStudi->name ?? '-';
                    }
                ]
            ],
            'kelas' => [
                'headers' => ['Kode Mata Kuliah', 'Kode Kelas', 'Kelas', 'Dosen', 'Tahun Akademik'],
                'mapping' => [
                    function ($class) {
                        return $class->course?->code ?? '-';
                    },
                    'id',
                    'name',
                    function ($class) {
                        return $class->lecturer?->user?->name ?? '-';
                    },
                    function ($class) {
                        return $class->academicYear->full_name ?? '-';
                    },
                ]
            ],
            'pengguna' => [
                'headers' => ['ID', 'Nama', 'Email', 'NIP'],
                'mapping' => [
                    'id',
                    'name',
                    'email',
                    function ($user) {
                        // store string NIP
                        return strval($user->lecturer->nip ?? '-');
                    }
                ]
            ]
        ];

        if (!isset($configs[$type])) {
            throw new Exception("Tipe '{$type}' tidak didukung untuk export/import");
        }

        return $configs[$type];
    }

    /**
     * Get data for export
     */
    private function getDataForExport(string $type, int $programStudiId): Collection
    {
        switch ($type) {
            case 'tahun_akademik':
                return AcademicYear::all();

            case 'mahasiswa':
                return Student::where('program_studi_id', $programStudiId)
                    ->with('programStudi')
                    ->get();

            case 'mata_kuliah':
                return Course::where('program_studi_id', $programStudiId)
                    ->with('programStudi')
                    ->get();

            case 'kelas':
                return ClassRoom::whereHas('course', function ($query) use ($programStudiId) {
                    $query->where('program_studi_id', $programStudiId);
                })
                    ->with(['course', 'lecturer', 'academicYear'])
                    ->get();
            case 'pengguna':
                return User::where('program_studi_id', $programStudiId)
                    ->with('lecturer')
                    ->get();

            default:
                throw new Exception("Tipe '{$type}' tidak didukung untuk export");
        }
    }
}
