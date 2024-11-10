<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\ClassRoom;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.admin.kelas.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courses = Course::all();
        $academicYears = AcademicYear::all();

        return view('pages.admin.kelas.create', compact('courses', 'academicYears'));
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

        // clean from empty string
        $classRoomNames = array_filter($classRoomNames);

        // implement db transaction
        try {
            DB::transaction(function () use ($classRoomNames, $validated) {
                $course = Course::find($validated['course_id']);
                $academicYear = AcademicYear::find($validated['academic_year_id']);

                foreach ($classRoomNames as $name) {
                    $course->classRooms()->create([
                        'name' => $name,
                        'code' => $course->code . '-' . $name,
                        'academic_year_id' => $academicYear->id,
                    ]);
                }
            });

            return redirect()->route('admin.kelas.index')
                ->with('success', 'Kelas berhasil dibuat');
        } catch (\Throwable $th) {

            return back()->with('error', 'Gagal membuat kelas : ' . $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ClassRoom $kelas)
    {
        $classroomLecturers = $kelas->report->lecturers->map(function ($lecturer) {
            return $lecturer->user->name;
        })->implode(', ');

        if ($kelas->report->lecturers->isEmpty()) {
            $classroomLecturers = $kelas->lecturer->user->name ?? '-';
        }

        $informasiUmum = [
            'Kode/Nama Kelas' => $kelas->id . '/' . $kelas->name,
            'Kode Mata Kuliah' => $kelas->course->code,
            'Dosen' => $classroomLecturers,
            'SKS' => $kelas->course->credit,
        ];

        return view('pages.admin.kelas.show', compact('kelas', 'informasiUmum'));
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
