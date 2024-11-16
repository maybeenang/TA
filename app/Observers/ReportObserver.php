<?php

namespace App\Observers;

use App\Jobs\GenerateReportPDF;
use App\Models\Report;
use App\Services\ReportService;
use Illuminate\Support\Facades\Log;

class ReportObserver
{

    protected $reportService;

    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    /**
     * Handle the Report "created" event.
     */
    public function created(Report $report): void
    {
        $this->reportService->reportCreated($report);
    }

    /**
     * Handle the Report "updated" event.
     */

    public function updating(Report $report): void
    {
        $report->load([
            'gradeComponents',
            'grades',
            'lecturers'
        ]);
        Log::info($report->hasRelationChanges([
            'gradeComponents',
            'grades',
            'lecturers'
        ]));
    }

    /**
     * Handle the Report "deleted" event.
     */
    public function deleted(Report $report): void
    {
        //
    }

    /**
     * Handle the Report "restored" event.
     */
    public function restored(Report $report): void
    {
        //
    }

    /**
     * Handle the Report "force deleted" event.
     */
    public function forceDeleted(Report $report): void
    {
        //
    }
}
