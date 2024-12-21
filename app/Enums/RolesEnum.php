<?php

namespace App\Enums;

use Illuminate\Contracts\View\View;

enum RolesEnum: string
{

    case SUPERADMIN = 'super-admin';
    case ADMIN = 'admin';
    case TENAGAPENGAJAR = 'tenaga-pengajar';
    case GKMP = 'gkmp';
    case KAPRODI = 'kaprodi';


    public function label(): string
    {
        return match ($this) {
            static::SUPERADMIN => 'Super Admin',
            static::ADMIN => 'Admin',
            static::TENAGAPENGAJAR => 'Tenaga Pengajar',
            static::GKMP => 'GKMP',
            static::KAPRODI => 'Kepala Program Studi',
        };
    }

    public function badge(): View
    {
        return match ($this) {
            static::SUPERADMIN => view('components.badges.super-admin'),
            static::ADMIN => view('components.badges.admin'),
            static::TENAGAPENGAJAR => view('components.badges.tenaga-pengajar'),
            static::GKMP => view('components.badges.gkmp'),
            static::KAPRODI => view('components.badges.kaprodi'),
        };
    }
}
