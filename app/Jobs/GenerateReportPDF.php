<?php

namespace App\Jobs;

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

            // check if student is not empty
            if ($this->report->classRoom->students->isEmpty()) {
                throw new \Exception('Tidak ada mahasiswa yang terdaftar di kelas ini');
            }

            // get min, max, range (max-min), average, from each graadecomponent score
            $distribusiNilai = $this->report->gradeComponents
                ->map(function ($gradeComponent) {
                    $scores = $gradeComponent->studentGrades->pluck('score');
                    return [
                        'name' => $gradeComponent->name,
                        'min' => $scores->min(),
                        'max' => $scores->max(),
                        'range' => $scores->max() - $scores->min(),
                        'average' => round($scores->avg(), 2),
                        'simpangan_baku' => $gradeComponent->standardDeviation(),
                    ];
                });

            // append new value to distribusiNilai
            $distribusiNilai->push([
                'name' => 'Nilai',
                'min' => $this->report->grades->min('total_score') ?? 0,
                'max' => $this->report->grades->max('total_score') ?? 0,
                'range' => $this->report->grades->max('total_score') - $this->report->grades->min('total_score'),
                'average' => $this->report->grades->avg('total_score') ?? 0,
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

            $pdfName = 'Laporan-' . $this->report->classRoom->fullName . '.pdf';

            $pdfName = str_replace(' ', '-', $pdfName);
            // check if path is exist
            //
            if (!Storage::exists('pdfs')) {
                Storage::makeDirectory('pdfs');
            }

            Pdf::view('pdfs.pdf-laporan', [
                'laporan' => $this->report,
                'distribusiNilai' => $distribusiNilai,
                'rentangNilai' => $rentangNilai,
            ])
                ->format(Format::A4)
                ->margins(3, 3, 3, 4, Unit::Centimeter)
                ->save(Storage::path('pdfs/' . $pdfName));

            $this->report->update([
                'pdf_path' => $pdfName,
                'pdf_status' => 'done',
            ]);

            broadcast(new PDFGenerated($this->report->id));
        } catch (\Throwable $th) {
            Log::error($th);
            throw $th;
        }
    }
}
