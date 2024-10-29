<?php

namespace App\Enums;

use Illuminate\Contracts\View\View;

enum ReportStatusEnum: string
{
        // case NAMEINAPP = 'name-in-database';

    case DRAFT = 'draft';
    case DIKIRIM = 'dikirim';
    case TERVERIFIKASI = 'terverifikasi';
    case DITOLAK = 'ditolak';

    // extra helper to allow for greater customization of displayed values, without disclosing the name/value data directly
    public function label(): string
    {
        return match ($this) {
            static::DRAFT => 'Draft',
            static::DIKIRIM => 'Dikirim',
            static::TERVERIFIKASI => 'Terverifikasi',
            static::DITOLAK => 'Ditolak',
        };
    }

    public function color(): string
    {
        return match ($this) {
            static::DRAFT => 'amber',
            static::DIKIRIM => 'blue',
            static::TERVERIFIKASI => 'green',
            static::DITOLAK => 'red',
        };
    }

    public static function toSelectArray(): array
    {
        foreach (self::cases() as $case) {
            $selectArray[$case->value] = $case->label();
        }
        return $selectArray;
    }
}
