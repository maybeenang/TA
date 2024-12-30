<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Lecturer;
use App\Models\Report;
use App\Services\KelasService;
use App\Services\LecturerService;
use App\Services\ReportService;
use Illuminate\Http\Request;

class LaporanController extends Controller
{

    public function __construct(
        protected KelasService $kelasService,
        protected ReportService $reportService,
        protected LecturerService $lecturerService
    ) {}


    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return view('pages.super-admin.laporan.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $classrooms = $this->kelasService->getAllClassrooms();
        return view('pages.super-admin.laporan.create', compact('classrooms'));
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

            return redirect()->route('super-admin.laporan.index')->with('success', 'Berhasil membuat laporan');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Gagal membuat laporan ' . $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Report $report)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Report $report)
    {
        $lecturers = $this->lecturerService->getAllLecturers();

        return view('pages.super-admin.laporan.edit', compact('report', 'lecturers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Report $report)
    {
        $validated = $request->validate([
            'lecturer' => 'nullable|exists:lecturers,id',
            'reportStatus' => 'required|exists:report_statuses,name',
            'note' => 'nullable|string',
        ]);

        try {

            $this->reportService->update($report, $validated);

            return redirect()->route('super-admin.laporan.index')->with('success', 'Berhasil mengubah laporan');
        } catch (\Throwable $th) {

            return redirect()->back()->with('error', 'Gagal mengubah laporan ' . $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Report $report)
    {
        try {
            $this->reportService->delete($report);

            return redirect()->route('super-admin.laporan.index')->with('success', 'Berhasil menghapus laporan');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Gagal menghapus laporan ' . $th->getMessage());
        }
    }
}
