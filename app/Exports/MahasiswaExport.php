<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MahasiswaExport implements FromQuery, WithMapping, WithHeadings, ShouldAutoSize
{
    use Exportable;

    public function query()
    {
        return Student::query()->authProgramStudi();
    }

    public function map($row): array
    {
        return [
            $row->nim,
            $row->name,
        ];
    }

    public function headings(): array
    {
        return [
            'NIM',
            'Nama',
        ];
    }
}
