<?php

namespace App\Services;

use App\Helpers\ImageHelper;
use App\Models\Report;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Spatie\Browsershot\Browsershot;
use Spatie\LaravelPdf\Enums\Format;
use Spatie\LaravelPdf\Enums\Unit;
use Spatie\LaravelPdf\Facades\Pdf;

class PDFGeneratorService
{
    /**
     * Generate PDF for a report
     */
    public function generate(Report $report): bool
    {
        try {
            // get min, max, range (max-min), average, from each graadecomponent score
            $distribusiNilai = $report->gradeComponents
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
                'min' => $report->grades->min('total_score') ?? 0,
                'max' => $report->grades->max('total_score') ?? 0,
                'range' => $report?->grades?->max('total_score') - $report->grades->min('total_score'),
                'average' => $report?->grades?->avg('total_score') ?? 0,
                'simpangan_baku' => $report->standarDeviation ?? 0,
            ]);


            $rentangNilai = $report->gradeScales->map(function ($gradeScale) use ($report) {
                return [
                    'letter' => $gradeScale->letter,
                    'min' => $gradeScale->min_score + 0,
                    'max' => $gradeScale->max_score + 0,
                    'count' => $report->grades->where('letter', $gradeScale->letter)->count(),
                ];
            });

            $verifikasiData = $report->verifikasiData();

            $classroomLecturers = $report->lecturers->map(function ($lecturer) {
                return $lecturer->user->name;
            })->implode(', ');

            if ($classroomLecturers === '') {
                $classroomLecturers = $report->classRoom?->lecturer?->user?->name ?? '-';
            }

            $detailLaporan = (object) [
                'dosenPengampu' => $classroomLecturers,
                'kelas' => $report->classRoom->name,
                'mataKuliah' => $report?->classRoom?->course?->code . ' ' . $report?->classRoom?->course?->name,
                'sks' => $report->classRoom?->course?->credit,
                'tahunAkademik' => $report->classRoom?->academicYear?->fullName,
            ];

            // delete last pdf if exist
            if ($report->pdf_path && Storage::exists('pdfs/' . $report->pdf_path)) {
                Storage::delete('pdfs/' . $report->pdf_path);
            }

            // generate random name with uuid
            $pdfName = Str::uuid() . '.pdf';

            if (!Storage::exists('pdfs')) {
                Storage::makeDirectory('pdfs');
            }

            $iteraLogoBase64 = ImageHelper::imageToBase64(public_path('itera.png'));

            Log::info('PDF Generation: ' . $pdfName);

            /* Browsershot::url(route('laporan.render')) */
            /*     ->post([ */
            /*         'laporan_id' => $report->id, */
            /*         'distribusi_nilai' => $distribusiNilai, */
            /*         'rentang_nilai' => $rentangNilai, */
            /*         'verifikasi_data' => $verifikasiData, */
            /*         'detail_laporan' => $detailLaporan, */
            /*     ]) */
            /*     ->setNodeBinary(config('app.nodejs.nodejs_path')) */
            /*     ->setNpmBinary(config('app.nodejs.npm_path')) */
            /*     ->noSandbox() */
            /*     ->setOption('args', ['--no-sandbox']) */
            /*     ->savePdf(Storage::path('pdfs/' . $pdfName)); */

            Pdf::view('pdfs.pdf-laporan', [
                'laporan' => $report,
                'distribusiNilai' => $distribusiNilai,
                'rentangNilai' => $rentangNilai,
                'verifikasiData' => $verifikasiData,
                'detailLaporan' => $detailLaporan,
                'iteraLogoBase64' => $iteraLogoBase64,
            ])
                ->format(Format::A4)
                ->margins(3, 3, 3, 4, Unit::Centimeter)
                ->withBrowsershot(function (Browsershot $browsershot) {
                    // Mengatasi masalah timeout pada artisan serve
                    $browsershot
                        ->setNodeBinary(config('app.nodejs.nodejs_path'))
                        ->setNpmBinary(config('app.nodejs.npm_path'))
                        ->noSandbox()
                        ->setOption('args', ['--no-sandbox']);
                })
                ->save(Storage::path('pdfs/' . $pdfName));

            $report->update([
                'pdf_path' => $pdfName,
                'pdf_status' => 'done',
            ]);

            return true;
        } catch (\Throwable $th) {
            Log::error("PDF Generation Error: " . $th->getMessage());
            Log::error($th);
            return false;
        }
    }
}
