<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait WithAuthProgramStudi
{
    protected $authProgramStudiId;

    public function bootWithAuthProgramStudi()
    {
        $this->authProgramStudiId = Auth::user()->programStudi?->id ?? null;
    }
}
