<?php

namespace App\Observers;

use App\Events\ReportUpdated;
use App\Jobs\GenerateReportPDF;
use App\Models\Report;
use App\Services\ReportService;
use Illuminate\Support\Facades\Cache;
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

    public function updated(Report $report): void
    {
        if ($report->isDirty(['signature_kaprodi_id', 'signature_gkmp_id', 'report_status_id'])) {
            broadcast(new ReportUpdated($report));
            Cache::forget('sidebar_badge_count');
        }

        // check apakah yang di update adalah pdf_path atau pdf_status
        if ($report->isDirty(['pdf_path', 'pdf_status'])) {
            return;
        }

        $cacheKey = "report_regenerating_{$report->id}";
        if (!Cache::has($cacheKey)) {
            Cache::put($cacheKey, true, now()->addSeconds(10));

            GenerateReportPDF::dispatch($report)
                ->delay(now()->addSeconds(5));
        }

        $userId = $report->classRoom?->lecturer?->user_id;

        if ($userId) {
            Cache::delete("lecturer_{$userId}");
        }

        Cache::forget('all_count_dashboard');
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
