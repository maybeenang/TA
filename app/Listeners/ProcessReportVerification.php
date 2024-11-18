<?php

namespace App\Listeners;

use App\Events\CheckingReport;
use App\Events\ReportVerified;
use App\Models\Report;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class ProcessReportVerification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(CheckingReport $event): void
    {
        $report = Report::find($event->reportId);

        if (!$report) {
            Log::error('Report not found');
            return;
        }

        $status = $report->progres();
        Log::info('Report status: ' . json_encode($status));

        // check all status is true
        if (in_array(false, $status, true)) {
            Log::info('Report not verified');
            // append status with result
            $status['result'] = false;

            broadcast(new ReportVerified($report->id, $status));
            return;
        }

        // append status with result
        $status['result'] = true;
        Log::info('Report verified');
        $report->report_status_id = 2;
        $report->save();

        broadcast(new ReportVerified($report->id, $status));
    }
}
