<?php

namespace App\Observers;

use App\Models\Report;

class ReportObserver
{
    /**
     * Handle the Report "created" event.
     */
    public function created(Report $report): void
    {
        // create 3 cmpk with loop
        for ($i = 1; $i <= 3; $i++) {
            $report->cpmks()->create([
                'code' => 'CPMK' . $i,
                'description' => 'Competency ' . $i,
                'criteria' => 'Criteria ' . $i,
                'average_score' => 0,
            ]);
        }

        // create 16 attendance and activity with loop
        for ($i = 1; $i <= 16; $i++) {
            $report->attendanceAndActivities()->create([
                'week' => $i,
                'meeting_name' => 'Minggu ke-' . $i,
                'student_present' => 0,
                'student_active' => 0,
            ]);
        }

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

    /**
     * Handle the Report "updated" event.
     */
    public function updated(Report $report): void
    {
        //
    }

    /**
     * Handle the Report "deleted" event.
     */
    public function deleted(Report $report): void
    {
        //
    }

    /**
     * Handle the Report "restored" event.
     */
    public function restored(Report $report): void
    {
        //
    }

    /**
     * Handle the Report "force deleted" event.
     */
    public function forceDeleted(Report $report): void
    {
        //
    }
}
