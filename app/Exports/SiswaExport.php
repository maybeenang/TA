<?php

namespace App\Exports;

use App\Models\StudentClassroom;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SiswaExport implements FromQuery, WithMapping, WithHeadings, ShouldAutoSize
{
    use Exportable;

    protected $authUser = false;

    public function forAuthUser()
    {
        $this->authUser = true;
        return $this;
    }

    public function query()
    {
        $query = StudentClassroom::query();

        if ($this->authUser) {
            $query->authProgramStudi();
        }

        return $query;
    }

    public function map($row): array
    {
        return [
            $row->student->name,
            $row->student->nim,
            $row->student->programStudi?->name,
            $row->classRoom->id,
            $row->classRoom->name,
            $row->classRoom->course->name,
        ];
    }

    public function headings(): array
    {
        return [
            "NAMA MAHASISWA",
            "NIM",
            "PROGRAM STUDI",
            "KODE KELAS",
            "KELAS",
            "MATA KULIAH"
        ];
    }
}
