<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\Setting\ExportImportService;
use App\Services\Admin\Setting\SyncService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MasterdataController extends Controller
{

    protected $exportImportService;
    protected $syncService;

    public function __construct(ExportImportService $exportImportService, SyncService $syncService)
    {
        $this->syncService = $syncService;
        $this->exportImportService = $exportImportService;

        // check if user has profram studi
        $programStudi = Auth::user()->programStudi;
        if (!$programStudi) {
            return redirect()->route('welcome')->with('error', 'Program studi tidak ditemukan.');
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $programStudi = Auth::user()->programStudi;

        $settings = $programStudi->settings()
            ->where('is_shown', true)
            ->get();

        return view('pages.admin.master-data.index', compact('settings', 'programStudi'));
    }

    protected function checkProgramStudi()
    {
        $programStudiId = Auth::user()->programStudi;

        if (!$programStudiId) {
            return redirect()->route('welcome')->with('error', 'Program studi tidak ditemukan.');
        }

        return $programStudiId;
    }

    public function export(Request $request, $type)
    {
        $programStudi = $this->checkProgramStudi();

        try {
            $filename = "{$type}_" . now()->format('Y-m-d_His') . '.xlsx';
            return $this->exportImportService->export($type, $programStudi->id)->download($filename, \Maatwebsite\Excel\Excel::XLSX, [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ]);
        } catch (\Throwable $th) {

            Log::error('Export gagal', [
                'error' => $th->getMessage(),
                'type' => $type,
                'program_studi_id' => $programStudi->id,
            ]);

            return redirect()->back()->with('error', 'Export gagal. Silahkan coba lagi.');
        }
    }

    public function sync(Request $request, $type)
    {
        $programStudi = $this->checkProgramStudi();
        try {
            $res = $this->syncService->sync($type);

            // update last synced by and last synced at
            $programStudi->settings()
                ->where('key', $type)
                ->update([
                    'last_synced_by' => Auth::user()->id,
                    'last_synced_at' => now(),
                ]);


            return redirect()->back()->with('success', $res['message']);
        } catch (\Throwable $th) {
            Log::error('Sync gagal', [
                'error' => $th->getMessage(),
                'type' => $type,
            ]);

            return redirect()->back()->with('error', 'Sync gagal. Silahkan coba lagi.');
        }
    }

    public function programStudiUpdate(Request $request)
    {
        $programStudi = $this->checkProgramStudi();
        $programStudi->update([
            'name' => $request->program_studi,
        ]);

        return redirect()->back()->with('success', 'Program studi berhasil diperbarui.');
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

    /**
     * Import data based on type
     */
    public function import(Request $request, $type)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:10240',
        ]);

        $programStudi = $this->checkProgramStudi();

        try {
            // Import data
            $result = $this->exportImportService->import($type, $programStudi->id, $request->file('file'));

            $programStudi->settings()
                ->where('key', $type)
                ->update([
                    'last_updated_by' => Auth::user()->id,
                    'last_updated_at' => now(),
                ]);

            if ($result['success']) {
                return redirect()->back()->with('success', $result['message']);
            }


            return redirect()->back()->with('error', $result['message']);
        } catch (\Throwable $th) {
            Log::error('Import gagal', [
                'error' => $th->getMessage(),
                'type' => $type,
                'program_studi_id' => $programStudi->id,
            ]);

            return redirect()->back()->with('error', 'Import gagal: ' . $th->getMessage());
        }
    }

    /**
     * Create import template for download
     */
    public function importTemplate($type)
    {
        $programStudi = $this->checkProgramStudi();

        try {
            $filename = "template_{$type}_" . now()->format('Y-m-d_His') . '.xlsx';
            return $this->exportImportService->createImportTemplate($type)->download($filename);
        } catch (\Throwable $th) {
            Log::error('Pembuatan template gagal', [
                'error' => $th->getMessage(),
                'type' => $type,
            ]);

            return redirect()->back()->with('error', 'Pembuatan template gagal: ' . $th->getMessage());
        }
    }
}
