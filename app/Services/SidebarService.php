<?php

namespace App\Services;

use App\Enums\ReportStatusEnum;
use App\Models\Report;
use Illuminate\Support\Facades\Cache;

class SidebarService
{
    public function getBadgeCount()
    {

        $adminLaporanVerifikasi = $this->query()->count();

        $kaprodiLaporanVerifikasi = $this->query()
            ->where('signature_kaprodi_id', null)->count();

        $gkmpLaporanVerifikasi = $this->query()
            ->where('signature_gkmp_id', null)->count();



        return [
            'adminLaporanVerifikasi' => $adminLaporanVerifikasi,
            'gkmpLaporanVerifikasi' => $gkmpLaporanVerifikasi,
            'kaprodiLaporanVerifikasi' => $kaprodiLaporanVerifikasi,
        ];
    }

    public function query()
    {
        return Report::query()->whereHas('reportStatus', function ($q) {
            $q->where('name', ReportStatusEnum::DIKIRIM->value);
        });
    }
}
