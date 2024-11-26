<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use App\Models\Lecturer;
use App\Models\Report;
use App\Services\AcademicYearService;
use App\Services\ReportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Reverb\Loggers\Log;

class LaporanController extends Controller
{

    protected $reportService;
    protected $academicYearService;

    public function __construct(ReportService $reportService, AcademicYearService $academicYearService)
    {
        $this->reportService = $reportService;
        $this->academicYearService = $academicYearService;
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.admin.laporan.index');
    }

    public function verifikasiLaporan()
    {
        return view('pages.admin.laporan.verifikasi-laporan');
    }


    public function arsipLaporan()
    {
        return view('pages.admin.laporan.arsip-laporan');
    }

    public function verifikasiLaporanEdit(Report $laporan)
    {
        $signatures = Auth::user()->signatures;
        return view('pages.admin.laporan.verifikasi-laporan-edit', compact('laporan', 'signatures'));
    }

    public function verifikasiLaporanUpdate(Request $request, Report $laporan)
    {
        $validated = $request->validate([
            'signature' => 'required|exists:signatures,id',
        ]);

        $signature = Auth::user()->signatures()->find($validated['signature']); // @intelliphense-ignore-line


        if (!$signature) {
            return redirect()->back()->with('error', 'Signature not found');
        }

        try {
            $this->reportService->verifikasiLaporan($laporan, $request->signature);
            return redirect()->route('admin.laporan.index')->with('success', 'Berhasil verifikasi laporan');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Gagal verifikasi laporan' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $classrooms = ClassRoom::query()
            ->whereHas('academicYear', function ($query) {
                $query->where('id', $this->academicYearService->getCurrentAcademicYear()->id);
            })
            ->get()
            ->map(function ($classroom) {
                return [
                    'value' => $classroom->id,
                    'label' => $classroom->full_name,
                ];
            });

        return view('pages.admin.laporan.create', compact('classrooms'));
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
        return view('pages.admin.laporan.show', compact('laporan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Report $laporan)
    {
        return view('pages.admin.laporan.edit', compact(
            'laporan',
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

            return redirect()->route('admin.laporan.edit', $laporan)
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
}
