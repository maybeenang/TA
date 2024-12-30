<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TahunAkademikRequest;
use App\Models\AcademicYear;
use App\Services\AcademicYearService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        return view('pages.admin.tahun-akademik.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.tahun-akademik.create');
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
            return redirect()->route('admin.tahun-akademik.index')
                ->with('success', 'Tahun Akademik berhasil dibuat');
        } catch (\Exception $e) {

            return back()->with('error', 'Gagal membuat tahun akademik : ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
