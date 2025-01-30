<?php

namespace App\Exports;

use App\Models\AcademicYear;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SuperAdminTahunAkademikExport implements FromQuery, WithMapping, WithHeadings, ShouldAutoSize
{
    use Exportable;

    public function query()
    {
        return AcademicYear::query();
    }

    public function map($row): array
    {
        return [
            $row->name,
            $row->semester,
            $row->start_date,
            $row->end_date,
        ];
    }

    public function headings(): array
    {
        return [
            'Nama',
            'Semester',
            'Tanggal Mulai',
            'Tanggal Selesai',
        ];
    }
}
