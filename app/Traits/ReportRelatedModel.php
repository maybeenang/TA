<?php

namespace App\Traits;

use App\Models\AttendanceAndActivity;
use App\Models\ClassRoom;
use App\Models\Cpmk;
use App\Models\Grade;
use App\Models\GradeComponent;
use App\Models\GradeScale;
use App\Models\Lecturer;
use App\Models\Quistionnaire;
use App\Models\Report;
use App\Models\ReportStatus;
use App\Models\StudentGrade;
use App\Services\PDFGeneratorService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

trait ReportRelatedModel
{
    public static function bootReportRelatedModel()
    {
        // Handle updated event
        /* static::updated(function ($model) { */
        /*     static::handleReportRegeneration($model); */
        /* }); */
        /**/
        /* // Handle deleted event (optional) */
        /* static::deleted(function ($model) { */
        /*     static::handleReportRegeneration($model); */
        /* }); */
    }

    protected static function handleReportRegeneration($model)
    {
        /* $reports = static::findRelatedReports($model); */
        /* $pdfService = app(PDFGeneratorService::class); */
        /**/
        /* foreach ($reports as $report) { */
        /*     // Gunakan cache untuk debouncing */
        /*     $cacheKey = "report_regenerating_{$report->id}"; */
        /**/
        /*     if (!Cache::has($cacheKey)) { */
        /*         Cache::put($cacheKey, true, now()->addSeconds(10)); */
        /**/
        /*         // Generate PDF langsung */
        /*         $pdfService->generate($report); */
        /*     } */
        /* } */
    }

    /* protected static function findRelatedReports($model): Collection */
    /* { */
    /*     $modelClass = get_class($model); */
    /**/
    /*     switch ($modelClass) { */
    /*         case Lecturer::class: */
    /*             return Report::where('responsible_lecturer', $model->id) */
    /*                 ->orWhereHas('lecturers', function ($query) use ($model) { */
    /*                     $query->where('lecturer_id', $model->id); */
    /*                 }) */
    /*                 ->get(); */
    /**/
    /*         case ClassRoom::class: */
    /*             return Report::where('class_room_id', $model->id)->get(); */
    /**/
    /*         case ReportStatus::class: */
    /*             return Report::where('report_status_id', $model->id)->get(); */
    /**/
    /*         case Cpmk::class: */
    /*         case AttendanceAndActivity::class: */
    /*         case Quistionnaire::class: */
    /*         case Grade::class: */
    /*         case GradeComponent::class: */
    /*         case GradeScale::class: */
    /*             return Report::where('id', $model->report_id)->get(); */
    /*         case StudentGrade::class: */
    /*             return Report::whereHas('grades', function ($query) use ($model) { */
    /*                 $query->where('id', $model->grade_id); */
    /*             })->get(); */
    /**/
    /*         default: */
    /*             return collect(); */
    /*     } */
    /* } */
}
