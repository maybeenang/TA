<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Services\PDFGeneratorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PDFController extends Controller
{
    public function print(Report $laporan)
    {
        try {
            // check if laporan pdf is exist
            if (!$laporan->pdf_path) {
                if (!app(PDFGeneratorService::class)->generate($laporan)) {
                    return response()->json(['message' => 'Gagal generate PDF, silahkan coba beberapa saat lagi'], 500);
                }
            }

            // check if pdf exists
            if (!Storage::exists('pdfs/' . $laporan->pdf_path)) {
                if (!app(PDFGeneratorService::class)->generate($laporan)) {
                    return response()->json(['message' => 'Gagal generate PDF, silahkan coba beberapa saat lagi'], 500);
                }
            }

            return Storage::download('pdfs/' . $laporan->pdf_path, $laporan->classroom->fullName . '.pdf');
        } catch (\Exception $e) {
            Log::error('PDF Print Error: ' . $e->getMessage());
            return response()->json(['message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    public function pdf(Report $laporan)
    {
        try {
            if (!$laporan->pdf_path) {
                if (!app(PDFGeneratorService::class)->generate($laporan)) {
                    return response()->json(['message' => 'Gagal generate PDF, silahkan coba beberapa saat lagi'], 500);
                }
            }

            // check if pdf exists
            if (!Storage::exists('pdfs/' . $laporan->pdf_path)) {
                if (!app(PDFGeneratorService::class)->generate($laporan)) {
                    return response()->json(['message' => 'Gagal generate PDF, silahkan coba beberapa saat lagi'], 500);
                }
            }

            return response()->file(Storage::path('pdfs/' . $laporan->pdf_path), [
                'Content-Type' => 'application/pdf',
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
                'Pragma' => 'no-cache',
                'Expires' => '0'
            ]);
        } catch (\Exception $e) {
            Log::error('PDF View Error: ' . $e->getMessage());
            return response()->json(['message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    public function render(Request $request)
    {
        // get application/x-www-form-urlencoded
        $data = $request->all();
        $laporan = Report::find($data['laporan_id']);
        $distribusiNilai = $data['distribusi_nilai'];
        $rentangNilai = $data['rentang_nilai'];
        $verifikasiData = $data['verifikasi_data'];
        $detailLaporan = $data['detail_laporan'];
        $iteraLogoBase64 = base64_encode(file_get_contents(public_path('itera.png')));

        return view('pdfs.pdf-laporan', [
            'laporan' => $laporan,
            'distribusiNilai' => $distribusiNilai,
            'rentangNilai' => $rentangNilai,
            'verifikasiData' => $verifikasiData,
            'detailLaporan' => $detailLaporan,
            'iteraLogoBase64' => $iteraLogoBase64,
        ]);
    }
}
