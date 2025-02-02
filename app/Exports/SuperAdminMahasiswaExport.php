<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SuperAdminMahasiswaExport implements FromQuery, WithMapping, WithHeadings, ShouldAutoSize
{
    use Exportable;

    public function query()
    {
        return Student::query();
    }

    public function map($row): array
    {
        return [
            $row->name,
            $row->nim,
            $row->programStudi?->name,
            $row->programStudi?->fakultas->name
        ];
    }

    public function headings(): array
    {
        return [
            'Nama',
            'NIM',
            'Program Studi',
            'Fakultas'
        ];
    }
}
