<?php

namespace App\Http\Controllers\TenagaPengajar;

use App\Http\Controllers\Controller;
use App\Models\Lecturer;
use App\Models\Report;
use App\Models\ReportLecturers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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

        return view('pages.tenaga-pengajar.laporan.edit', compact(
            'laporan',
            'lecturers',
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Report $laporan)
    {

        // check if request step is not null with match
        $request->validate([
            'step' => 'required|in:informasi-umum,metode-perkuliahan',
        ]);

        match ($request->step) {
            'informasi-umum' => $this->updateInformasiUmum($request, $laporan),
            'metode-perkuliahan' => $this->updateMetodePerkuliahan($request, $laporan),
            default => abort(404),
        };

        return redirect()->route('tenaga-pengajar.laporan.edit', $laporan)
            ->with('success', 'Berhasil mengubah laporan')
            ->withFragment($request->step);
    }

    public function updateInformasiUmum(Request $request, Report $laporan)
    {
        $validated = $request->validate([
            'responsible_lecturer' => 'nullable',
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
    }

    public function updateMetodePerkuliahan(Request $request, Report $laporan)
    {
        $validated = $request->validate([
            'teaching_methods' => 'nullable',
            'self_evaluation' => 'nullable',
            'follow_up_plan' => 'nullable',
        ]);

        try {
            DB::transaction(function () use ($laporan, $validated) {
                $laporan->update($validated);
            });
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Gagal mengubah laporan' . $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
