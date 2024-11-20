<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Services\ReportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Reverb\Loggers\Log;

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
        return view('pages.admin.laporan.index');
    }

    public function verifikasiLaporan()
    {
        return view('pages.admin.laporan.verifikasi-laporan');
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
