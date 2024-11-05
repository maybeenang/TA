<?php

namespace App\Http\Controllers\TenagaPengajar;

use App\Http\Controllers\Controller;
use App\Models\Lecturer;
use App\Models\Report;
use App\Models\ReportLecturers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\TryCatch;

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
            // check if user is not null
            ->whereHas('user')
            ->get()
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
        $validated = $request->validate([
            'responsible_lecturer' => 'required',
            'teaching_methods' => 'required',
            'self_evaluation' => 'required',
            'follow_up_plan' => 'required',
            'report_lecturers' => 'array',
        ]);

        try {
            DB::transaction(function () use ($laporan, $validated) {
                $laporan->update($validated);

                // check if report_lecturers is not null
                if (isset($validated['report_lecturers'])) {
                    $laporan->lecturers()->sync($validated['report_lecturers']);
                } else {
                    $laporan->lecturers()->sync([]);
                }
            });
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Gagal mengubah laporan' . $th->getMessage());
        }

        return redirect()->route('tenaga-pengajar.laporan.select')->with('success', 'Berhasil mengubah laporan');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
