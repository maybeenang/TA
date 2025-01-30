<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ExportEnum;
use App\Http\Controllers\Controller;
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
}
