<?php

namespace App\Http\Controllers\TenagaPengajar;

use App\Http\Controllers\Controller;
use App\Models\Lecturer;
use App\Models\Report;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.tenaga-pengajar.laporan.index');
    }

    public function select()
    {
        return view('pages.tenaga-pengajar.laporan.select');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.tenaga-pengajar.laporan.create');
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
    public function edit(Report $laporan)
    {
        $lecturers = Lecturer::query()
            ->with('user')
            ->get()
            // format to ['id' => $id, 'name' => $name]
            ->map(function ($lecturer) {
                return [
                    'value' => $lecturer->id,
                    'label' => $lecturer->user->name,
                ];
            });

        return view('pages.tenaga-pengajar.laporan.edit', compact('laporan', 'lecturers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Report $laporan)
    {
        dd($laporan);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
