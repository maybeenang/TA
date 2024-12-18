<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class RoleService
{

    public function getLoggedInRole()
    {
        return auth()->user()->roles->first()->name;
    }
}
