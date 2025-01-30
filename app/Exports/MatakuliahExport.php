<?php

namespace App\Exports;

use App\Models\Course;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MatakuliahExport implements FromQuery, WithMapping, WithHeadings, ShouldAutoSize
{
    use Exportable;

    public function query()
    {
        return Course::query()->authProgramStudi();
    }

    public function headings(): array
    {
        return [
            'Kode',
            'Nama',
            'SKS'
        ];
    }

    public function map($row): array
    {
        return [
            $row->code,
            $row->name,
            $row->credit
        ];
    }
}
