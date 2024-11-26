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

    public function getLecturerById()
    {
        $userId = auth()->id();

        if (!$userId) {
            return null;
        }

        return Cache::remember("lecturer_{$userId}", 3600, function () use ($userId) {

            $self = Lecturer::query()
                ->with('user')
                ->where('user_id', $userId)
                ->first();

            if (!$self) {
                return null;
            }

            $classroomCount = $self?->classRooms()
                ->where('academic_year_id', $this->academicYearService->getCurrentAcademicYear()->id)
                ->count();

            // count all laporan from classroom but with status draft or ditolak
            $laporanBelumSelesaiCount = $self->classRooms()
                ->where('academic_year_id', $this->academicYearService->getCurrentAcademicYear()->id)
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

            $laporanSelesaiCount = $self->classRooms()
                ->where('academic_year_id', $this->academicYearService->getCurrentAcademicYear()->id)
                ->withCount([
                    'report as report_count' => function ($query) {
                        $query->whereHas('reportStatus', function ($query) {
                            $query->where('name', ReportStatusEnum::TERVERIFIKASI->value);
                        });
                    }
                ])
                ->get()
                ->sum('report_count');

            // return obj
            return (object) [
                'classroomCount' => $classroomCount,
                'laporanBelumSelesaiCount' => $laporanBelumSelesaiCount,
                'laporanSelesaiCount' => $laporanSelesaiCount,
            ];
        });
    }
}
