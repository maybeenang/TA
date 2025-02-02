<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SuperAdminPenggunaExport implements FromQuery, WithMapping, WithHeadings, ShouldAutoSize
{
    use Exportable;

    public function query()
    {
        return User::query();
    }

    public function map($user): array
    {
        return [
            $user->name,
            $user->email,
            $user->lecturer?->nip,
            $user->programStudi?->name,
            $user->programStudi?->fakultas?->name
        ];
    }

    public function headings(): array
    {
        return [
            'Nama',
            'Email',
            'NIP',
            'Program Studi',
            'Fakultas'
        ];
    }
}
