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
                ->first();
        });
    }

    public function getAllAcademicYears()
    {
        return Cache::remember('all_academic_years', 3600, function () {
            return AcademicYear::all();
        });
    }

    public function getAllCountDashboard()
    {
        return Cache::remember('all_count_dashboard', 3600, function () {
            $academicYear = $this->getCurrentAcademicYear();
            $laporanCount = $academicYear->classRooms()
                ->withCount('report')
                ->get()
                ->sum('report_count');
            $laporanBelumSelesaiCount = $academicYear->classRooms()
                ->withCount([
                    'report as report_count' => function ($query) {
                        $query->whereHas('reportStatus', function ($query) {
                            $query->where('name', ReportStatusEnum::DRAFT->value)
                                ->orWhere('name', ReportStatusEnum::DITOLAK->value);
                        });
                    }
                ])
                ->get()
                ->sum('report_count');

            $laporanSudahSelesaiCount = $laporanCount - $laporanBelumSelesaiCount;

            return (object) [
                'laporanCount' => $laporanCount,
                'laporanBelumSelesaiCount' => $laporanBelumSelesaiCount,
                'laporanSudahSelesaiCount' => $laporanSudahSelesaiCount,
            ];
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
