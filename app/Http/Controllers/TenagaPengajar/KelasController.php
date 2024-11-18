<?php

namespace App\Http\Controllers\TenagaPengajar;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use Illuminate\Http\Request;

class KelasController extends Controller
{
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
}
