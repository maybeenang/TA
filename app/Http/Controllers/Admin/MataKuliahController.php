<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class MataKuliahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.admin.mata-kuliah.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.mata-kuliah.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:255|unique:courses,code',
            'name' => 'required|string|max:255',
            'credit' => 'required|numeric',
        ]);

        try {
            Course::create([
                'name' => $validated['name'],
                'code' => $validated['code'],
                'credit' => $validated['credit'],
                'program_studi_id' => auth()->user()->program_studi_id,
            ]);
        } catch (\Throwable $th) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menambahkan mata kuliah');
        }

        return redirect()->route('admin.mata-kuliah.index')
            ->with('success', 'Mata Kuliah berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $mataKuliah)
    {
        return view('pages.admin.mata-kuliah.show', compact('mataKuliah'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $mataKuliah)
    {
        return view('pages.admin.mata-kuliah.edit', compact('mataKuliah'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $mataKuliah)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'credit' => 'required|numeric',
        ]);

        try {
            $mataKuliah->update([
                'name' => $validated['name'],
                'credit' => $validated['credit'],
            ]);

            return redirect()->route('admin.mata-kuliah.index')
                ->with('success', 'Mata Kuliah berhasil diubah');
        } catch (\Throwable $th) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat mengubah mata kuliah');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $mataKuliah)
    {
        try {
            $mataKuliah->delete();
        } catch (\Throwable $th) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menghapus mata kuliah');
        }

        return redirect()->route('admin.mata-kuliah.index')
            ->with('success', 'Mata Kuliah berhasil dihapus');
    }
}
