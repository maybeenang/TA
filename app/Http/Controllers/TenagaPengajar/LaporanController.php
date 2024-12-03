<?php

namespace App\Http\Controllers\TenagaPengajar;

use App\Enums\ReportStatusEnum;
use App\Enums\RolesEnum;
use App\Events\GradeComponentUpdated;
use App\Exports\ExportReportPenilaian;
use App\Http\Controllers\Controller;
use App\Imports\ImportReportPenilaian;
use App\Jobs\GenerateReportPDF;
use App\Models\Lecturer;
use App\Models\Report;
use App\Models\User;
use App\Notifications\AdminReportVerification;
use App\Services\ReportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{

    protected $reportService;

    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }

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
            $this->reportService->store($validated);

            return redirect()->route('tenaga-pengajar.laporan.edit', Report::where('class_room_id', $validated['classroom'])->first())
                ->with('success', 'Berhasil membuat laporan');
        } catch (\Throwable $th) {
            Log::error($th);
            return redirect()->back()->with('error', 'Gagal membuat laporan ' . $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Report $laporan)
    {
        return view('pages.tenaga-pengajar.laporan.show', compact('laporan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Report $laporan)
    {
        $reportStatus = $laporan->reportStatus->name;

        Log::info('Report status: ' . $reportStatus);

        if ($reportStatus !== ReportStatusEnum::DRAFT->value && $reportStatus !== ReportStatusEnum::DITOLAK->value) {
            $msg = 'Laporan tidak dapat diedit karena sudah ' . $reportStatus . ', jika anda merasa ini adalah kesalahan, silahkan hubungi admin';
            return view('pages.tenaga-pengajar.laporan.laporan-terverifikasi', compact('laporan', 'msg'));
        }

        return view('pages.tenaga-pengajar.laporan.edit', compact(
            'laporan',
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Report $laporan)
    {
        try {
            $request->validate([
                'step' => 'required|in:informasi-umum,metode-perkuliahan',
            ]);

            match ($request->step) {
                'informasi-umum' => $this->reportService->updateInformasiUmum($laporan, $request->all()),
                'metode-perkuliahan' => $this->reportService->updateMetodePerkuliahan($laporan, $request->all()),
                default => abort(404),
            };

            return redirect()->route('tenaga-pengajar.laporan.edit', $laporan)
                ->with('success', 'Berhasil mengubah laporan')
                ->withFragment($request->step);
        } catch (\Throwable $th) {
            Log::error($th);
            return redirect()->back()->with('error', 'Gagal mengupdate laporan');
        }
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    public function pengajuanVerifikasi(Report $laporan)
    {
        $status = $laporan->progres();

        if (in_array(false, $status, true)) {
            return response()->json([
                'message' => 'Mohon maaf, Pengajuan verifikasi laporan gagal, silahkan periksa kembali data laporan anda',
                'result' => false,
            ])->setStatusCode(400);
        }

        try {
            $this->reportService->ajukanVerifikasi($laporan);

            // send notification to all admin
            $admins = User::role(RolesEnum::ADMIN->value)->get();
            Notification::send($admins, new AdminReportVerification($laporan));

            return response()->json([
                'message' => 'Selamat!, Pengajuan verifikasi laporan berhasil',
                'result' => true,
            ])->setStatusCode(200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Gagal mengajukan verifikasi laporan',
                'result' => false,
            ])->setStatusCode(500);
        }
    }

    public function exportPenilaian(Report $laporan)
    {
        $name = 'penilaian-' . $laporan->classRoom->fullName . '.xlsx';
        // replace space with dash
        $name = str_replace(' ', '-', $name);
        return (new ExportReportPenilaian($laporan))->download($name);
    }

    public function importPenilaian(Request $request, Report $laporan)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        try {
            $file = $request->file('file');

            (new ImportReportPenilaian($laporan))->import($file);

            event(new GradeComponentUpdated($laporan));

            return redirect()->back()->with('success', 'Berhasil mengimport data penilaian');
        } catch (\Throwable $th) {
            Log::error($th);
            return redirect()->back()->with('error', 'Gagal mengimport data penilaian');
        }
    }
}
