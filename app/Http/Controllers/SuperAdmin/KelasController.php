<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\ClassRoom;
use App\Models\Course;
use App\Services\KelasService;
use App\Services\ScraperService;
use Illuminate\Http\Request;

class KelasController extends Controller
{

    protected KelasService $kelasService;
    protected ScraperService $scraperService;

    public function __construct(KelasService $kelasService, ScraperService $scraperService)
    {
        $this->kelasService = $kelasService;
        $this->scraperService = $scraperService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.super-admin.kelas.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courses = Course::all();
        $academicYears = AcademicYear::all();
        return view('pages.super-admin.kelas.create', compact('courses', 'academicYears'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'course_id' => 'required|exists:courses,id',
            'academic_year_id' => 'required|exists:academic_years,id',
        ]);

        $classRoomNames = array_map('trim', explode(',', $validated['name']));
        try {
            foreach ($classRoomNames as $name) {
                $this->kelasService->create([
                    'name' => $name,
                    'course_id' => $validated['course_id'],
                    'academic_year_id' => $validated['academic_year_id'],
                ]);
            }
            return redirect()->route('super-admin.kelas.index')
                ->with('success', 'Kelas berhasil dibuat');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal membuat kelas : ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ClassRoom $classRoom)
    {

        $classroomLecturers = $classRoom->report->lecturers->map(function ($lecturer) {
            return $lecturer->user->name;
        })->implode(', ');

        if ($classRoom->report->lecturers->isEmpty()) {
            $classroomLecturers = $classRoom->lecturer->user->name ?? '-';
        }

        $informasiUmum = [
            'Kode/Nama Kelas' => $classRoom->id . '/' . $classRoom->name,
            'Kode Mata Kuliah' => $classRoom->course->code,
            'Dosen' => $classroomLecturers,
            'SKS' => $classRoom->course->credit,
        ];

        return view('pages.super-admin.kelas.show', compact('classRoom', 'informasiUmum'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ClassRoom $classRoom)
    {

        $courses = Course::all();
        $academicYears = AcademicYear::all();

        return view('pages.super-admin.kelas.edit', compact('classRoom', 'courses', 'academicYears'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ClassRoom $classRoom)
    {

        $validated = $request->validate([
            'name' => 'required|string',
            'course_id' => 'required|exists:courses,id',
            'academic_year_id' => 'required|exists:academic_years,id',
        ]);

        try {
            $this->kelasService->update($classRoom->id, $validated);

            return redirect()->route('super-admin.kelas.index')
                ->with('success', 'Kelas berhasil diupdate');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengupdate kelas : ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ClassRoom $classRoom)
    {

        try {
            $this->kelasService->delete($classRoom->id);

            return redirect()->route('super-admin.kelas.index')
                ->with('success', 'Kelas berhasil dihapus');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus kelas : ' . $e->getMessage());
        }
    }

    public function scrapeData(ClassRoom $classRoom)
    {
        try {

            $this->scraperService->screpaKelas($classRoom->id);


            return back()
                ->with('success', 'Kelas berhasil di scrape');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengambil data kelas : ' . $e->getMessage());
        }
    }
}
