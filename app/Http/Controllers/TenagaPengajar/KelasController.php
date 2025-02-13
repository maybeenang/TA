<?php

namespace App\Http\Controllers\TenagaPengajar;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use App\Models\Student;
use App\Services\KelasService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KelasController extends Controller
{

    public function __construct(
        protected KelasService $kelasService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.tenaga-pengajar.kelas.index');
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
    public function show(ClassRoom $kelas)
    {

        if ($kelas->lecturer?->user_id !== Auth::id()) {
            return redirect()->route('tenaga-pengajar.kelas.index')->with('error', 'Anda tidak memiliki akses ke kelas ini');
        }

        $classroomlecturers = $kelas->report->lecturers->map(function ($lecturer) {
            return $lecturer->user->name;
        })->implode(', ');

        if ($kelas->report->lecturers->isempty()) {
            $classroomlecturers = $kelas->lecturer->user->name ?? '-';
        }

        $informasiUmum = [
            'kode/nama kelas' => $kelas->id . '/' . $kelas->name,
            'kode mata kuliah' => $kelas->course->code,
            'dosen' => $classroomlecturers,
            'sks' => $kelas->course->credit,
        ];


        return view('pages.tenaga-pengajar.kelas.show', compact('kelas', 'informasiUmum'));
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

    public function tambahMahasiswa(ClassRoom $kelas)
    {

        if ($kelas->lecturer?->user_id !== Auth::id()) {
            return redirect()->route('tenaga-pengajar.kelas.index')->with('error', 'Anda tidak memiliki akses ke kelas ini');
        }

        $students = Student::all()->map(function ($student) {
            return [
                'value' => $student->id,
                'label' => $student->nim . ' ' . $student->name,
            ];
        });

        session()->put('previous_url', url()->previous());

        return view('pages.tenaga-pengajar.kelas.tambah-mahasiswa', compact('kelas', 'students'));
    }

    public function storeMahasiswa(Request $request, ClassRoom $kelas)
    {
        $validated = $request->validate([
            'students' => 'required|array',
            'students.*' => 'required|exists:students,id',
        ]);

        $this->kelasService->addStudentClassroom($kelas, $validated['students']);

        $redirectUrl = session()->pull('previous_url', route('tenaga-pengajar.kelas.show', $kelas->id)) ?? route('tenaga-pengajar.kelas.show', $kelas->id);

        return redirect()->to($redirectUrl)
            ->with('success', 'Mahasiswa berhasil ditambahkan');
    }
}
