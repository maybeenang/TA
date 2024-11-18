<?php

namespace App\Http\Controllers\TenagaPengajar;

use App\Http\Controllers\Controller;
use App\Jobs\GenerateReportPDF;
use App\Models\Lecturer;
use App\Models\Report;
use App\Services\ReportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class LaporanController extends Controller
{

    protected $reportService;

    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.tenaga-pengajar.laporan.index');
    }

    public function select()
    {
        return view('pages.tenaga-pengajar.laporan.select');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $classrooms = Lecturer::query()
            ->with('classrooms')
            ->where('user_id', Auth::id())
            ->get()
            ->map(function ($lecturer) {
                return $lecturer->classrooms;
            })
            ->flatten()
            ->map(function ($classroom) {
                return [
                    'value' => $classroom->id,
                    'label' => $classroom->full_name,
                ];
            });

        return view('pages.tenaga-pengajar.laporan.create', compact('classrooms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'classroom' => 'required|exists:class_rooms,id',
        ]);

        try {
            $this->reportService->store($validated);

            return redirect()->route('tenaga-pengajar.laporan.edit', Report::where('class_room_id', $validated['classroom'])->first())
                ->with('success', 'Berhasil membuat laporan');
        } catch (\Throwable $th) {
            Log::error($th);
            return redirect()->back()->with('error', 'Gagal membuat laporan ' . $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Report $laporan)
    {
        return view('pages.tenaga-pengajar.laporan.show', compact('laporan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Report $laporan)
    {
        $lecturers = Lecturer::query()
            ->with('user')
            // check if user is not null
            ->whereHas('user')
            ->get()
            ->map(function ($lecturer) {
                return [
                    'value' => $lecturer->id,
                    'label' => $lecturer->user->name,
                ];
            });

        return view('pages.tenaga-pengajar.laporan.edit', compact(
            'laporan',
            'lecturers',
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Report $laporan)
    {
        try {

            $request->validate([
                'step' => 'required|in:informasi-umum,metode-perkuliahan',
            ]);

            match ($request->step) {
                'informasi-umum' => $this->reportService->updateInformasiUmum($laporan, $request->all()),
                'metode-perkuliahan' => $this->reportService->updateMetodePerkuliahan($laporan, $request->all()),
                default => abort(404),
            };

            return redirect()->route('tenaga-pengajar.laporan.edit', $laporan)
                ->with('success', 'Berhasil mengubah laporan')
                ->withFragment($request->step);
        } catch (\Throwable $th) {
            Log::error($th);
            return redirect()->back()->with('error', 'Gagal mengupdate laporan');
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

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

        return response()->file(Storage::path('pdfs/' . $laporan->pdf_path));
    }
}
