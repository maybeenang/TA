<?php

namespace App\Enums;

use Illuminate\Contracts\View\View;

enum RolesEnum: string
{
        // case NAMEINAPP = 'name-in-database';

    case ADMIN = 'admin';
    case TENAGAPENGAJAR = 'tenaga-pengajar';

    case GKMP = 'gkmp';
    case KAPRODI = 'kaprodi';


    // extra helper to allow for greater customization of displayed values, without disclosing the name/value data directly
    public function label(): string
    {
        return match ($this) {
            static::ADMIN => 'Admin',
            static::TENAGAPENGAJAR => 'Tenaga Pengajar',
            static::GKMP => 'GKMP',
            static::KAPRODI => 'Kepala Program Studi',
        };
    }

    public function badge(): View
    {
        return match ($this) {
            static::ADMIN => view('components.badges.admin'),
            static::TENAGAPENGAJAR => view('components.badges.tenaga-pengajar'),
            static::GKMP => view('components.badges.gkmp'),
            static::KAPRODI => view('components.badges.kaprodi'),
        };
    }
}
