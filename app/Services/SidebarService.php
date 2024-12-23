<?php

namespace App\Services;

use App\Enums\ReportStatusEnum;
use App\Models\Report;
use Illuminate\Support\Facades\Cache;

class SidebarService
{

    protected AcademicYearService $academicYearService;
    public function __construct()
    {
        $this->academicYearService = app(AcademicYearService::class);
    }

    public function getBadgeCount()
    {
        return Cache::remember('sidebar_badge_count', 3600, function () {

            $adminLaporanVerifikasi = $this->query()->count();

            $kaprodiLaporanVerifikasi = $this->query()
                ->where('signature_kaprodi_id', null)->count();

            $gkmpLaporanVerifikasi = $this->query()
                ->where('signature_gkmp_id', null)->count();

            $buatLaporanCount = Report::query()
                ->with(['classRoom', 'reportStatus'])
                ->whereHas('classRoom', function ($query) {
                    $query->where('academic_year_id', $this->academicYearService->getCurrentAcademicYear()->id);
                    $query->whereHas('lecturer.user', fn($query) => $query->where('id', auth()->id()));
                })
                ->whereHas('reportStatus', function ($query) {
                    $query->where('name', '!=', ReportStatusEnum::TERVERIFIKASI);
                    $query->where('name', '!=', ReportStatusEnum::DIKIRIM);
                })
                ->count();

            return [
                'adminLaporanVerifikasi' => $adminLaporanVerifikasi,
                'gkmpLaporanVerifikasi' => $gkmpLaporanVerifikasi,
                'kaprodiLaporanVerifikasi' => $kaprodiLaporanVerifikasi,
                'buatLaporanCount' => $buatLaporanCount
            ];
        });
    }

    public function query()
    {
        return Report::query()->whereHas('reportStatus', function ($q) {
            $q->where('name', ReportStatusEnum::DIKIRIM->value);
        });
    }
}
