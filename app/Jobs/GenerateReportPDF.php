<?php

namespace App\Jobs;

use App\Enums\ReportStatusEnum;
use Illuminate\Support\Str;
use App\Events\PDFGenerated;
use App\Models\Report;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Spatie\LaravelPdf\Enums\Format;
use Spatie\LaravelPdf\Enums\Unit;
use Spatie\LaravelPdf\Facades\Pdf;

class GenerateReportPDF implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public Report $report)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {

            // get min, max, range (max-min), average, from each graadecomponent score
            $distribusiNilai = $this->report->gradeComponents
                ->map(function ($gradeComponent) {
                    $scores = $gradeComponent->studentGrades->pluck('score');
                    // get scores length
                    return [
                        'name' => $gradeComponent->name,
                        'min' => $scores->min() ?? 0,
                        'max' => $scores->max() ?? 0,
                        'range' => $scores->max() - $scores->min() ?? 0,
                        'average' => round($scores->avg(), 2) ?? 0,
                        'simpangan_baku' => $gradeComponent->standardDeviation() ?? 0,
                    ];
                });


            // append new value to distribusiNilai
            $distribusiNilai->push([
                'name' => 'Nilai',
                'min' => $this->report->grades->min('total_score') ?? 0,
                'max' => $this->report->grades->max('total_score') ?? 0,
                'range' => $this->report?->grades?->max('total_score') - $this->report->grades->min('total_score'),
                'average' => $this->report?->grades?->avg('total_score') ?? 0,
                'simpangan_baku' => $this->report->standarDeviation ?? 0,
            ]);


            $rentangNilai = $this->report->gradeScales->map(function ($gradeScale) {
                return [
                    'letter' => $gradeScale->letter,
                    'min' => $gradeScale->min_score + 0,
                    'max' => $gradeScale->max_score + 0,
                    'count' => $this->report->grades->where('letter', $gradeScale->letter)->count(),
                ];
            });

            $verifikasiData = $this->report->verifikasiData();

            $classroomLecturers = $this->report->lecturers->map(function ($lecturer) {
                return $lecturer->user->name;
            })->implode(', ');

            if ($classroomLecturers === '') {
                $classroomLecturers = $this->report->classRoom?->lecturer?->user?->name ?? '-';
            }

            $detailLaporan = (object) [
                'dosenPengampu' => $classroomLecturers,
                'kelas' => $this->report->classRoom->name,
                'mataKuliah' => $this->report?->classRoom?->course?->code . ' ' . $this->report?->classRoom?->course?->name,
                'sks' => $this->report->classRoom?->course?->credit,
                'tahunAkademik' => $this->report->classRoom?->academicYear?->fullName,
            ];

            // delete last pdf if exist
            if ($this->report->pdf_path && Storage::exists('pdfs/' . $this->report->pdf_path)) {
                Storage::delete('pdfs/' . $this->report->pdf_path);
            }

            // generate random name with uuid
            $pdfName = Str::uuid() . '.pdf';

            if (!Storage::exists('pdfs')) {
                Storage::makeDirectory('pdfs');
            }

            Pdf::view('pdfs.pdf-laporan', [
                'laporan' => $this->report,
                'distribusiNilai' => $distribusiNilai,
                'rentangNilai' => $rentangNilai,
                'verifikasiData' => $verifikasiData,
                'detailLaporan' => $detailLaporan,
            ])
                ->format(Format::A4)
                ->margins(3, 3, 3, 4, Unit::Centimeter)
                ->save(Storage::path('pdfs/' . $pdfName));

            $this->report->update([
                'pdf_path' => $pdfName,
                'pdf_status' => 'done',
            ]);

            broadcast(new PDFGenerated($this->report->id, true));
        } catch (\Throwable $th) {
            Log::error($th);
            broadcast(new PDFGenerated($this->report->id, false));
            throw $th;
        }
    }
}
