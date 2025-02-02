<?php

namespace App\Exports\TenagaPengajar;

use App\Models\StudentClassroom;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MahasiswaKelasExport implements FromQuery, WithMapping, WithHeadings, ShouldAutoSize
{
    use Exportable;

    protected $kelasId;

    public function forKelas($kelasId)
    {
        $this->kelasId = $kelasId;
        return $this;
    }

    public function query()
    {
        return StudentClassroom::query()->whereHas('classRoom', function ($query) {
            $query->where('id', $this->kelasId);
        });
    }

    public function map($row): array
    {
        return [
            $row->student->name,
            $row->student->nim,
        ];
    }

    public function headings(): array
    {
        return [
            "NAMA MAHASISWA",
            "NIM",
        ];
    }
}
