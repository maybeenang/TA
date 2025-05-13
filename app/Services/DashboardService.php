<?php

namespace App\Services;

use App\Enums\ReportStatusEnum;
use App\Models\Report;

class DashboardService
{
    /**
     * Create a new class instance.
     */

    protected AcademicYearService $academicYearService;

    public function __construct()
    {
        $this->academicYearService = app(AcademicYearService::class);
    }

    protected function laporanQuery()
    {
        return Report::query()
            ->whereHas('classRoom', function ($query) {
                $query->where('academic_year_id', $this->academicYearService->getCurrentAcademicYear()?->id ?? null);
                $query->whereHas('course', function ($query) {
                    $query->where('program_studi_id', auth()->user()->program_studi_id);
                });
            });
    }


    public function adminDashboardData()
    {
        $jumlahLaporan = $this->laporanQuery()->count();
        $jumlahLaporanSelesai = $this->laporanQuery()->whereHas('reportStatus', function ($q) {
            $q->where('name', ReportStatusEnum::TERVERIFIKASI->value);
        })->count();
        return (object) [
            'jumlahLaporan' => $jumlahLaporan,
            'jumlahLaporanSelesai' => $jumlahLaporanSelesai,
            'jumlahLaporanBelumSelesai' => $jumlahLaporan - $jumlahLaporanSelesai,
        ];
    }

    public function tenagaPengajarLaporanata()
    {
        $jumlahLaporan = $this->laporanQuery()->whereHas('classRoom', function ($query) {
            $query->where('lecturer_id', auth()->user()->lecturer?->id);
        })->count();

        $jumlahLaporanSelesai = $this->laporanQuery()->whereHas('classRoom', function ($query) {
            $query->where('lecturer_id', auth()->user()->lecturer?->id);
        })->whereHas('reportStatus', function ($q) {
            $q->where('name', ReportStatusEnum::TERVERIFIKASI->value);
        })->count();

        return (object) [
            'jumlahLaporan' => $jumlahLaporan,
            'jumlahLaporanSelesai' => $jumlahLaporanSelesai,
            'jumlahLaporanBelumSelesai' => $jumlahLaporan - $jumlahLaporanSelesai,
        ];
    }
}
