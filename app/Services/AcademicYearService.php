<?php

namespace App\Services;

use App\Models\AcademicYear;
use Illuminate\Support\Facades\Cache;

class AcademicYearService
{
    public function getCurrentAcademicYear()
    {
        return Cache::remember('current_academic_year', 3600, function () {
            $now = now();
            return AcademicYear::where('start_date', '<=', $now)
                ->where('end_date', '>=', $now)
                ->first()
                ?? AcademicYear::where('start_date', '>=', $now)
                ->orderBy('start_date', 'asc')
                ->first();
        });
    }

    public function getAllAcademicYears()
    {
        return Cache::remember('all_academic_years', 3600, function () {
            return AcademicYear::all();
        });
    }
}
