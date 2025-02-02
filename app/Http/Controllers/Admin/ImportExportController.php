<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ExportEnum;
use App\Exports\TenagaPengajar\MahasiswaKelasExport;
use App\Http\Controllers\Controller;
use App\Imports\TenagaPengajar\MahasiswaKelasImport;
use App\Models\ClassRoom;
use Illuminate\Http\Request;

class ImportExportController extends Controller
{
    public function export($type)
    {
        return ExportEnum::from($type)->exportData();
    }

    public function import(Request $request, $type)
    {
        $validated = $request->validate([
            'file' => 'required|file|mimes:xlsx,xls',
        ]);

        $import = ExportEnum::from($type)->importData($validated['file']);
        return redirect()->back()->with('success', 'Data berhasil diimport');
    }

    public function exportMahasiswaKelas(ClassRoom $kelas)
    {
        $fileName = 'mahasiswa_kelas_' . $kelas->id . '.xlsx';

        return (new MahasiswaKelasExport)->forKelas($kelas->id)->download($fileName);
    }

    public function importMahasiswaKelas(Request $request, ClassRoom $kelas)
    {
        $validated = $request->validate([
            'file' => 'required|file|mimes:xlsx,xls',
        ]);

        $import = (new MahasiswaKelasImport($kelas->id))->import($validated['file']);
        return redirect()->back()->with('success', 'Data berhasil diimport');
    }
}
