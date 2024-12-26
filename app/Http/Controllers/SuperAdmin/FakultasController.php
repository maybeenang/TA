<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Fakultas;
use App\Services\FakultasSerivce;
use Illuminate\Http\Request;

class FakultasController extends Controller
{

    public function __construct(
        protected FakultasSerivce $fakultasService
    ) {}


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.super-admin.fakultas.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.super-admin.fakultas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|string|unique:fakultas,name',
        ]);

        try {
            $this->fakultasService->create($validated);

            return redirect()->route('super-admin.fakultas.index')->with('success', 'Berhasil menambahkan fakultas');
        } catch (\Throwable $th) {
            return back()->withInput()->with('error', 'Gagal menambahkan fakultas ' . $th->getMessage());
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
    public function edit(Fakultas $fakultas)
    {

        return view('pages.super-admin.fakultas.edit', compact('fakultas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Fakultas $fakultas)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:fakultas,name,' . $fakultas->id,
        ]);

        try {
            $this->fakultasService->update($fakultas, $validated);

            return redirect()->route('super-admin.fakultas.index')->with('success', 'Berhasil mengubah fakultas');
        } catch (\Throwable $th) {
            return back()->withInput()->with('error', 'Gagal mengubah fakultas ' . $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fakultas $fakultas)
    {
        try {
            $this->fakultasService->delete($fakultas);

            return redirect()->route('super-admin.fakultas.index')->with('success', 'Berhasil menghapus fakultas');
        } catch (\Throwable $th) {
            return back()->with('error', 'Gagal menghapus fakultas ' . $th->getMessage());
        }
    }
}
