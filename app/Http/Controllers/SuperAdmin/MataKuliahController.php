<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\ProgramStudi;
use App\Services\MataKuliahService;
use Illuminate\Http\Request;

class MataKuliahController extends Controller
{

    protected MataKuliahService $mataKuliahService;

    public function __construct(MataKuliahService $mataKuliahService)
    {
        $this->mataKuliahService = $mataKuliahService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.super-admin.mata-kuliah.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $programStudis = ProgramStudi::pluck('name', 'id');

        return view('pages.super-admin.mata-kuliah.create', compact('programStudis'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'code' => 'required|string|unique:courses',
            'credit' => 'required|numeric',
            'program_studi_id' => 'required|exists:program_studis,id',
        ]);

        try {
            $this->mataKuliahService->create($validated);

            return redirect()->route('super-admin.mata-kuliah.index')
                ->with('success', 'Mata Kuliah berhasil dibuat');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal membuat mata kuliah : ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        $programStudis = ProgramStudi::pluck('name', 'id');

        return view('pages.super-admin.mata-kuliah.edit', compact('course', 'programStudis'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'code' => 'required|string|unique:courses,code,' . $course->id,
            'credit' => 'required|numeric',
            'program_studi_id' => 'required|exists:program_studis,id',
        ]);

        try {
            $this->mataKuliahService->update($course->id, $validated);

            return redirect()->route('super-admin.mata-kuliah.index')
                ->with('success', 'Mata Kuliah berhasil diubah');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengubah mata kuliah : ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        try {
            $this->mataKuliahService->delete($course->id);

            return redirect()->route('super-admin.mata-kuliah.index')
                ->with('success', 'Mata Kuliah berhasil dihapus');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus mata kuliah : ' . $e->getMessage());
        }
    }
}
