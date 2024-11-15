<?php

namespace App\Http\Controllers\TenagaPengajar;

use App\Http\Controllers\Controller;
use App\Models\Lecturer;
use App\Models\Report;
use App\Models\ReportLecturers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PhpParser\Node\Stmt\TryCatch;
use Spatie\Browsershot\Browsershot;
use Spatie\LaravelPdf\Enums\Format;
use Spatie\LaravelPdf\Enums\Unit;
use Spatie\LaravelPdf\Facades\Pdf;

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
        $classrooms = Lecturer::query()
            ->with('classrooms')
            ->where('user_id', Auth::id())
            ->get()
            ->map(function ($lecturer) {
                return $lecturer->classrooms;
            })
            ->flatten()
            ->map(function ($classroom) {
                return [
                    'value' => $classroom->id,
                    'label' => $classroom->full_name,
                ];
            });

        return view('pages.tenaga-pengajar.laporan.create', compact('classrooms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'classroom' => 'required|exists:class_rooms,id',
        ]);

        try {
            // check if classroom has report
            if (Report::where('class_room_id', $validated['classroom'])->exists()) {
                return redirect()->back()->with('error', 'Kelas ini sudah memiliki laporan');
            }

            DB::transaction(function () use ($validated) {
                $report = Report::create([
                    'class_room_id' => $validated['classroom'],
                ]);

                $report->lecturers()->attach(Auth::id());
            });
        } catch (\Throwable $th) {
            Log::error($th);
            return redirect()->back()->with('error', 'Gagal membuat laporan');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Report $laporan)
    {
        // get min, max, range (max-min), average, from each graadecomponent score
        $distribusiNilai = $laporan->gradeComponents
            ->map(function ($gradeComponent) {
                $scores = $gradeComponent->studentGrades->pluck('score');
                return [
                    'name' => $gradeComponent->name,
                    'min' => $scores->min(),
                    'max' => $scores->max(),
                    'range' => $scores->max() - $scores->min(),
                    'average' => $scores->average(),
                    'simpangan_baku' => $gradeComponent->standardDeviation(),
                ];
            });

        // append new value to distribusiNilai
        $distribusiNilai->push([
            'name' => 'Nilai',
            'min' => $laporan->grades->min('total_score'),
            'max' => $laporan->grades->max('total_score'),
            'range' => $laporan->grades->max('total_score') - $laporan->grades->min('total_score'),
            'average' => $laporan->grades->avg('total_score'),
            'simpangan_baku' => $laporan->standarDeviation,
        ]);

        Pdf::view('pdfs.pdf-laporan', compact('laporan', 'distribusiNilai'))
            ->format(Format::A4)
            ->margins(3, 3, 3, 4, Unit::Centimeter)
            ->save(storage_path('app/public/sampul.pdf'));
        return view('pages.tenaga-pengajar.laporan.show', compact('laporan'));
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
