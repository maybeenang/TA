<?php

namespace App\Services;

use App\Enums\ReportStatusEnum;
use App\Models\AcademicYear;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

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
                ->first() ?? null;
        });
    }

    public function getAllAcademicYears()
    {
        return Cache::remember('all_academic_years', 3600, function () {
            return AcademicYear::query()
                ->orderBy('id', 'desc')
                ->get();
        });
    }

    public function getOptionsAcademicYears()
    {
        return Cache::remember('options_academic_years', 3600, function () {
            return AcademicYear::pluck('fullName', 'id');
        });
    }

    public function createAcademicYear(array $validated)
    {
        return DB::transaction(function () use ($validated) {
            AcademicYear::create($validated);
        });
    }

    public function updateAcademicYear(AcademicYear $academicYear, array $validated)
    {
        return DB::transaction(function () use ($academicYear, $validated) {
            $academicYear->update($validated);
        });
    }

    public function deleteAcademicYear(AcademicYear $academicYear)
    {
        return DB::transaction(function () use ($academicYear) {
            $academicYear->delete();
        });
    }
}
