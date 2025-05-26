<?php

namespace App\Services;

use App\Enums\ReportStatusEnum;
use App\Jobs\GenerateReportPDF;
use App\Models\Lecturer;
use App\Models\Report;
use App\Models\ReportStatus;
use App\Notifications\ReportTolak;
use App\Notifications\TenagaPengajarReportVerification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PhpParser\Node\Expr\Throw_;

class ReportService
{
    protected $generateReportPDF;
    public function __construct(
        GenerateReportPDF $generateReportPDF
    ) {
        $this->generateReportPDF = $generateReportPDF;
    }

    public function reportCreated(Report $report)
    {

        $report->update([
            'teaching_methods' => 'Metode perkuliahan yang digunakan dalam mata kuliah ini adalah Bentuk : kuliah, responsi, tutorial, seminar atau yang setara, praktikum, praktik studio, praktik bengkel, praktik lapangan, penelitian, pengabdian kepada masyarakat dan atau bentuk pembelajaran lainya. Metode Pembelajaran contoh :Problem-Based Learning (PBL). Buku referensi yang digunakan adalah Digital Systems: Principles and Applications ditulis oleh Ronald J. Tocci dan Digital Electronics: Principles and Application karya ditulis oleh Roger L. Tokheim',
            'self_evaluation' => 'Mata kuliah sistem logika dan digital merupakan mata kuliah pilihan kelompok keahlian instrumentasi. Jumlah mahasiswa yang mengambil mata kuliah ini berjumlah 13 orang. Partisipasi kehadiran mahasiswa pada perkuliahan ini selama satu semester dapat dikatakan cukup baik dengan tingkat kehadiran >80%. Tingkat keaktifan mahasiswa sebesar 9% dimana kurang dari setengah jumlah mahasiswa untuk aktif berdiskusi atau bertanya pada saat perkuliahan berlangsung, hal tersebut dapat terjadi mungkin disebabkan bahan(diksi) materi(soal) yang diberikan cukup sulit dipahami mahasiswa dan efek kelelahan mahasiswa karena perkuliahan diadakan pada saat siang menjelang sore. Proses perkuliahan dibagi menjadi 2 sks pemberian teori (konsep) di kelas selama 14 kali pertemuan dan 1 sks praktikum di laboratorium fisika serta 2 kali ujian (UTS dan UAS). Namun adanya miskomunikasi pada pihak laboratorium maka praktikum tidak berjalan sesuai dengan yang diharapkan. Hasil dari perkuliahan ini dapat dikatakan cukup walaupun masih ada beberapa kekurangan seperti soal-soal latihan yang diberikan untuk mahasiswa belajar mendalami konsep dan aplikasi digital dalam kehidupan sehari-hari.',
            'follow_up_plan' => 'Tindak lanjut perkuliahan di tahun akademik 2020/2021 maka diperlukan upaya pembuatan soal-soal dan diberikan tugas besar perkuliahan yang dapat membuat mahasiswa lebih mendalami konsep sistem logika digital serta penyusunan jadwal penyelenggaran kuliah yang tepat termasuk praktikum sehingga mahasiswa memiliki jeda waktu istirahat saat pergantian mata kuliah'
        ]);

        // create 3 cmpk with loop
        for ($i = 1; $i <= 3; $i++) {
            $report->cpmks()->create([
                'code' => 'CPMK' . $i,
            ]);
        }

        // create 16 attendance and activity with loop
        for ($i = 1; $i <= 16; $i++) {
            $report->attendanceAndActivities()->create([
                'week' => $i,
                'meeting_name' => 'Minggu ke-' . $i,
            ]);
        }

        // spek penilaian
        $report->gradeComponents()->createMany([
            [
                'name' => "UTS",
                'weight' => 0,
            ],
            [
                'name' => "UAS",
                'weight' => 0,
            ],
            [
                'name' => "Kuis",
            ],
            [
                'name' => "Tugas",
                'weight' => 0,
            ],
            [
                'name' => "Praktikum",
                'weight' => 0,
            ],
            [
                'name' => "RBL",
            ],
            [
                'name' => "Kehadiran",
                'weight' => 0,
            ],
        ]);

        $defaultGradeScale  = [
            'A' => [
                'max_score' => 100,
                'min_score' => 85,
                'score' => 4,
            ],
            'AB' => [
                'max_score' => 84,
                'min_score' => 75,
                'score' => 3.5,
            ],
            'B' => [
                'max_score' => 74,
                'min_score' => 65,
                'score' => 3,
            ],
            'BC' => [
                'max_score' => 64,
                'min_score' => 55,
                'score' => 2.5,
            ],
            'C' => [
                'max_score' => 54,
                'min_score' => 45,
                'score' => 2,
            ],
            'D' => [
                'max_score' => 44,
                'min_score' => 25,
                'score' => 1,
            ],
            'E' => [
                'max_score' => 24,
                'min_score' => 0,
                'score' => 0,
            ],
        ];

        $report->gradeScales()->createMany(
            array_map(
                fn($letter, $score) => [
                    'letter' => $letter,
                    'max_score' => $score['max_score'],
                    'min_score' => $score['min_score'],
                    'score' => $score['score'],
                ],
                array_keys($defaultGradeScale),
                $defaultGradeScale
            )
        );


        $defaultQuistionnaire = [
            'agree' => 0,
            'disagree' => 0,
            'strongly_agree' => 0,
            'strongly_disagree' => 0,
        ];

        $report->quistionnaires()->createMany(
            [
                [
                    'statement' => 'Kontrak perkuliahan disampaikan dengan jelas pada awal kuliah/praktikum',
                    ...$defaultQuistionnaire,
                ],
                [
                    'statement' => 'Materi kuliah/praktikum disampaikan sesuai jadwal di kontrak perkuliahan',
                    ...$defaultQuistionnaire,
                ],
                [
                    'statement' => 'Tersedia bahan ajar kuliah/praktikum (handout/modul/penuntun praktikum) yang lengkap',
                    ...$defaultQuistionnaire,
                ],
                [
                    'statement' => 'Tugas kuliah/praktikum sesuai dengan materi perkuliahan',
                    ...$defaultQuistionnaire,
                ],
                [
                    'statement' => 'Tugas yang diberikan meningkatkan penguasaan materi kuliah',
                    ...$defaultQuistionnaire,
                ],
                [
                    'statement' => 'Kuliah/praktikum dilaksanakan sesuai dengan jadwal yang ditetapkan',
                    ...$defaultQuistionnaire,
                ],
                [
                    'statement' => 'Pemahaman mahasiswa meningkat setelah mengikuti perkuliahan',
                    ...$defaultQuistionnaire,
                ],
                [
                    'statement' => 'Metode pengajaran dosen efektif meningkatkan pemahaman materi',
                    ...$defaultQuistionnaire,
                ],
                [
                    'statement' => 'Nilai UTS/UAS diumumkan paling lambat dua minggu dari jadwal perkuliahan terakhir',
                    ...$defaultQuistionnaire,
                ],
                [
                    'statement' => 'Absensi diedarkan pada pertemuan kuliah/praktikum secara teratur',
                    ...$defaultQuistionnaire,
                ],
                [
                    'statement' => 'Soal ujian sesuai dengan materi kuliah yang disampaikan',
                    ...$defaultQuistionnaire,
                ],
            ]
        );
    }

    public function store(array $validated)
    {

        return DB::transaction(function () use ($validated) {

            if (Report::where('class_room_id', $validated['classroom'])->exists()) {
                throw new \Exception('Laporan sudah ada');
            }

            $report = Report::create([
                'class_room_id' => $validated['classroom'],
                'report_status_id' => 1,
            ]);

            return $report;
        });
    }


    public function updateInformasiUmum(Report $laporan, array $validated)
    {
        return DB::transaction(function () use ($laporan, $validated) {
            $laporan->update($validated);

            // check if report_lecturers is not null
            if (isset($validated['report_lecturers'])) {
                $laporan->lecturers()->sync($validated['report_lecturers']);
            } else {
                $laporan->lecturers()->sync([]);
            }
            return $laporan;
        });
    }

    public function updateMetodePerkuliahan(Report $laporan, array $validated)
    {
        return DB::transaction(function () use ($laporan, $validated) {
            $laporan->update($validated);

            return $laporan;
        });
    }

    public function tolakLaporan($id, string $catatan = '')
    {
        $laporan = Report::find($id);
        return DB::transaction(function () use ($laporan, $catatan) {
            $laporan->update([
                'report_status_id' => 4,
                'note' => $catatan,
            ]);

            // notify user if laporan->classroom->lecturer->user->id
            if ($laporan->classRoom?->lecturer?->user) {
                $laporan->classRoom->lecturer->user->notify(new ReportTolak($laporan));
            }

            return $laporan;
        });
    }

    public function verifikasiLaporan(Report $laporan, array $data)
    {
        return DB::transaction(function () use ($laporan, $data) {

            $verifiedStatus = ReportStatus::where('name', ReportStatusEnum::TERVERIFIKASI->value)->first();
            $signature = $data['role'] == 'kaprodi' ? 'signature_kaprodi_id' : 'signature_gkmp_id';
            $verifikator = $data['role'] == 'kaprodi' ? 'verifikator_kaprodi' : 'verifikator_gkmp';

            $laporan->update([
                $verifikator => Auth::id(),
                $signature => $data['signature'],
            ]);

            if ($laporan->verifikator_gkmp && $laporan->verifikator_kaprodi) {
                $laporan->update([
                    'report_status_id' => $verifiedStatus->id,
                    'verified_at' => now(),
                ]);

                // notify tenaga pengajar
                if ($laporan?->classRoom?->lecturer?->user) {
                    $laporan->classRoom->lecturer->user->notify(new TenagaPengajarReportVerification($laporan));
                }
            }

            return $laporan;
        });
    }

    public function ajukanVerifikasi(Report $laporan)
    {
        return DB::transaction(function () use ($laporan) {
            $laporan->update([
                'report_status_id' => 2,
            ]);

            return $laporan;
        });
    }

    public function convertCamelCase($camelCaseString)
    {
        // Tambahkan spasi sebelum huruf kapital yang diikuti oleh huruf kecil
        $result = preg_replace("/([a-z])([A-Z])/", '$1 $2', $camelCaseString);
        // Ubah kata pertama dari setiap kata menjadi huruf besar
        return ucwords($result);
    }

    public function exportExcelPenilaian(Report $laporan) {}


    public function update(Report $report, array $validated)
    {
        return DB::transaction(function () use ($validated, &$report) {
            $status = ReportStatus::where('name', $validated['reportStatus'])->first();

            if (isset($validated['lecturer'])) {
                $lecturer = Lecturer::find($validated['lecturer']);
                $classroom = $report->classRoom;
                $classroom->update([
                    'lecturer_id' => $lecturer->id,
                ]);
            }

            $report->update([
                'report_status_id' => $status->id,
            ]);

            if ($validated['reportStatus'] === ReportStatusEnum::DITOLAK->value) {
                $report->update([
                    'note' => $validated['note'] ?? null,
                ]);
            }

            return $report;
        });
    }

    public function delete(Report $report)
    {
        return DB::transaction(function () use ($report) {
            $report->delete();
        });
    }
}
