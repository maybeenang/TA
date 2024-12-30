<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Fakultas;
use App\Models\ProgramStudi;
use App\Services\ProgramStudiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProgramStudiController extends Controller
{

    protected ProgramStudiService $programStudiService;

    public function __construct()
    {
        $this->programStudiService = app(ProgramStudiService::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.super-admin.program-studi.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $fakultas = Fakultas::pluck('name', 'id')->toArray();
        return view('pages.super-admin.program-studi.create', compact('fakultas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|string',
            'fakultas' => 'required|exists:fakultas,id',
        ]);

        $validated['fakultas_id'] = $validated['fakultas'];

        try {

            $this->programStudiService->create($validated);

            return redirect()->route('super-admin.program-studi.index')
                ->with('success', 'Program Studi berhasil dibuat');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal membuat program studi : ' . $e->getMessage());
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
    public function edit(ProgramStudi $programStudi)
    {
        $fakultas = Fakultas::pluck('name', 'id')->toArray();
        return view('pages.super-admin.program-studi.edit', compact('programStudi', 'fakultas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProgramStudi $programStudi)
    {

        $validated = $request->validate([
            'name' => 'required|string',
            'fakultas' => 'required|exists:fakultas,id',
        ]);

        $validated['fakultas_id'] = $validated['fakultas'];

        try {
            $this->programStudiService->update($programStudi->id, $validated);

            return redirect()->route('super-admin.program-studi.index')
                ->with('success', 'Program Studi berhasil diupdate');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengupdate program studi : ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProgramStudi $programStudi)
    {

        try {
            $this->programStudiService->delete($programStudi->id);

            return redirect()->route('super-admin.program-studi.index')
                ->with('success', 'Program Studi berhasil dihapus');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus program studi : ' . $e->getMessage());
        }
    }

    public function scrapeData()
    {
        try {
            $this->programStudiService->scrapeData();
            return redirect()->route('super-admin.program-studi.index')
                ->with('success', 'Data program studi berhasil di scrape');
        } catch (\Throwable $th) {
            return back()->with('error', 'Gagal mengambil data program studi' . $th->getMessage());
        }
    }
}
