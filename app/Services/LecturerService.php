<?php

namespace App\Services;

use App\Enums\ReportStatusEnum;
use App\Models\Lecturer;
use Illuminate\Support\Facades\Cache;

class LecturerService
{
    protected $academicYearService;

    public function __construct()
    {
        $this->academicYearService = app(AcademicYearService::class);
    }

    public function getAllLecturers()
    {
        return Cache::remember('all_lecturers', 3600, function () {
            return Lecturer::query()
                ->with('user')
                ->whereHas('user')
                ->get();
        });
    }
}
