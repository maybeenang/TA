<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\ProgramStudi;
use App\Models\Student;
use App\Services\StudentService;
use Illuminate\Http\Request;

class StudentController extends Controller
{

    public function __construct(
        protected StudentService $studentService
    ) {}



    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.super-admin.student.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $programStudis = ProgramStudi::pluck('name', 'id');
        return view(
            'pages.super-admin.student.create',
            compact('programStudis')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nim' => 'required|string|unique:students,nim|digits_between:8,20',
            'name' => 'required|string',
            'programStudi' => 'required|exists:program_studis,id',
        ]);

        try {
            $this->studentService->create($validated);

            return redirect()->route('super-admin.student.index')->with('success', 'Berhasil menambahkan mahasiswa');
        } catch (\Throwable $th) {
            return back()->withInput()->with('error', 'Gagal menambahkan mahasiswa ' . $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {

        $programStudis = ProgramStudi::pluck('name', 'id');

        return view(
            'pages.super-admin.student.edit',
            compact('student', 'programStudis')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'nim' => 'required|string|digits_between:8,20|unique:students,nim,' . $student->id,
            'name' => 'required|string',
            'programStudi' => 'required|exists:program_studis,id',
        ]);

        try {
            $this->studentService->update($student, $validated);

            return redirect()->route('super-admin.student.index')->with('success', 'Berhasil mengubah mahasiswa');
        } catch (\Throwable $th) {
            return back()->withInput()->with('error', 'Gagal mengubah mahasiswa ' . $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        try {
            $student->delete();

            return redirect()->route('super-admin.student.index')->with('success', 'Berhasil menghapus mahasiswa');
        } catch (\Throwable $th) {
            return back()->withInput()->with('error', 'Gagal menghapus mahasiswa ' . $th->getMessage());
        }
    }
}
