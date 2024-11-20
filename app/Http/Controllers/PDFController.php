<?php

namespace App\Http\Controllers;

use App\Jobs\GenerateReportPDF;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PDFController extends Controller
{
    public function print(Report $laporan)
    {
        // check if laporan pdf is exist
        if (!$laporan->pdf_path) {
            GenerateReportPDF::dispatch($laporan);
            return response()->json(['message' => 'PDF sedang dibuat, silahkan coba beberapa saat lagi'], 404);
        }

        // check ig pdf es exist
        if (!Storage::exists('pdfs/' . $laporan->pdf_path)) {
            GenerateReportPDF::dispatch($laporan);
            return response()->json(['message' => 'PDF sedang dibuat, silahkan coba beberapa saat lagi'], 404);
        }

        return Storage::download('pdfs/' . $laporan->pdf_path);
    }

    public function pdf(Report $laporan)
    {
        if (!$laporan->pdf_path) {
            GenerateReportPDF::dispatch($laporan);
            // return not found
            return response()->json(['message' => 'PDF sedang dibuat, silahkan coba beberapa saat lagi'], 404);
        }

        // check ig pdf es exist
        if (!Storage::exists('pdfs/' . $laporan->pdf_path)) {
            GenerateReportPDF::dispatch($laporan);
            return response()->json(['message' => 'PDF sedang dibuat, silahkan coba beberapa saat lagi'], 404);
        }

        return response()->file(Storage::path('pdfs/' . $laporan->pdf_path), [
            'Content-Type' => 'application/pdf',
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0'
        ]);
    }
}
