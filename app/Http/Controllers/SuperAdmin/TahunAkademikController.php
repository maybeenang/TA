<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TahunAkademikRequest;
use App\Models\AcademicYear;
use App\Services\AcademicYearService;
use Illuminate\Http\Request;

class TahunAkademikController extends Controller
{

    protected AcademicYearService $academicYearService;

    public function __construct()
    {
        $this->academicYearService = app(AcademicYearService::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.super-admin.tahun-akademik.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.super-admin.tahun-akademik.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TahunAkademikRequest $request)
    {
        $validated = $request->validated();

        // implement db transaction
        try {

            $this->academicYearService->createAcademicYear($validated);

            return redirect()->route('super-admin.tahun-akademik.index')
                ->with('success', 'Tahun Akademik berhasil dibuat');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal membuat tahun akademik : ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(AcademicYear $academicYear)
    {
        return view('pages.super-admin.tahun-akademik.show', compact('academicYear'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AcademicYear $academicYear)
    {
        return view('pages.super-admin.tahun-akademik.edit', compact('academicYear'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TahunAkademikRequest $request, AcademicYear $academicYear)
    {

        $validated = $request->validated();

        try {
            $this->academicYearService->updateAcademicYear($academicYear, $validated);


            return redirect()->route('super-admin.tahun-akademik.index')
                ->with('success', 'Tahun Akademik berhasil diupdate');
        } catch (\Throwable $th) {

            return back()->with('error', 'Gagal mengupdate tahun akademik : ' . $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AcademicYear $academicYear)
    {
        try {
            $this->academicYearService->deleteAcademicYear($academicYear);

            return redirect()->route('super-admin.tahun-akademik.index')
                ->with('success', 'Tahun Akademik berhasil dihapus');
        } catch (\Throwable $th) {
            return back()->with('error', 'Gagal menghapus tahun akademik : ' . $th->getMessage());
        }
    }
}
