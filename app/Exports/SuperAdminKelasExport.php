<?php

namespace App\Exports;

use App\Models\ClassRoom;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SuperAdminKelasExport implements FromQuery, WithMapping, WithHeadings, ShouldAutoSize
{
    use Exportable;

    public function query()
    {
        return ClassRoom::query();
    }

    public function map($row): array
    {
        return [
            $row->id,
            $row->name,
            $row->course?->code,
            $row->course?->name,
            $row->course?->credit,
            $row->course?->programStudi?->name,
            $row->lecturer?->user?->name,
            $row->academicYear?->name,
            $row->academicYear?->semester,
        ];
    }

    public function headings(): array
    {
        return [
            'Kode',
            'Nama',
            'Kode Mata Kuliah',
            'Nama Mata Kuliah',
            'SKS',
            'Program Studi',
            'Nama Dosen',
            'Tahun Akademik',
            'Semester',
        ];
    }
}
