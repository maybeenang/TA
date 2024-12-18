<?php

namespace App\Http\Controllers\Gkmp;

use App\Enums\ReportStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Notifications\TenagaPengajarReportVerification;
use App\Services\AcademicYearService;
use App\Services\ReportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        return view('pages.gkmp.laporan.index');
    }

    public function verifikasi(Report $laporan)
    {
        // check is laporan status is not submitted
        if ($laporan->reportStatus->name !== ReportStatusEnum::DIKIRIM->value) {
            abort(404);
        }

        $signatures = Auth::user()->signatures;

        return view('pages.gkmp.laporan.verifikasi-laporan-edit', compact('laporan', 'signatures'));
    }

    public function verifikasiLaporanUpdate(Request $request, Report $laporan)
    {
        $validated = $request->validate([
            'signature' => 'required|exists:signatures,id',
        ]);

        $validated['role'] = 'gkmp';

        $signature = Auth::user()->signatures()->find($validated['signature']); // @intelliphense-ignore-line

        if (!$signature) {
            return redirect()->back()->with('error', 'Tanda tangan tidak ditemukan');
        }

        try {
            $this->reportService->verifikasiLaporan($laporan, $validated);

            // notify tenaga pengajar
            if ($laporan?->classRoom?->lecturer?->user) {
                $laporan->classRoom->lecturer->user->notify(new TenagaPengajarReportVerification($laporan));
            }

            return redirect()->route('gkmp.laporan.index')->with('success', 'Berhasil verifikasi laporan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal verifikasi laporan' . $e->getMessage());
        }
    }

    public function arsipLaporan()
    {
        return view('pages.gkmp.laporan.arsip-laporan');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
