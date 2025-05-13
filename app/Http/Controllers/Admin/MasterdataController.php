<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MasterdataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dataAkademik = [
            [
                'title' => 'Tahun Akademik',
                'last_updated' => '2023-10-01',
                'last_synced' => '2023-10-02',
                'export' => 'Export',
                'import' => 'Import',
                'sync' => 'Sinkronisasi',
            ],
            [
                'title' => 'Mahasiswa',
                'last_updated' => '2023-10-01',
                'last_synced' => '2023-10-02',
                'export' => 'Export',
                'import' => 'Import',
                'sync' => 'Sinkronisasi',
            ],
            [
                'title' => 'Pengguna',
                'last_updated' => '2023-10-01',
                'last_synced' => '2023-10-02',
                'export' => 'Export',
                'import' => 'Import',
                'sync' => 'Sinkronisasi',
            ],
            [
                'title' => 'Mata Kuliah',
                'last_updated' => '2023-10-01',
                'last_synced' => '2023-10-02',
                'export' => 'Export',
                'import' => 'Import',
                'sync' => 'Sinkronisasi',
            ],
            [
                'title' => 'Kelas',
                'last_updated' => '2023-10-01',
                'last_synced' => '2023-10-02',
                'export' => 'Export',
                'import' => 'Import',
                'sync' => 'Sinkronisasi',
            ],
        ];

        return view('pages.admin.master-data.index', compact('dataAkademik'));
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
