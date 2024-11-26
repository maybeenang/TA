<?php

namespace App\Listeners;

use App\Enums\ReportStatusEnum;
use App\Events\CheckingReport;
use App\Events\ReportVerified;
use App\Models\Report;
use App\Services\ReportService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class ProcessReportVerification
{
    /**
     * Create the event listener.
     */
    public function __construct(public ReportService $reportService)
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

        Log::info('Checking report verification');


        // check if report status id is 2
        if ($report->reportStatus->name === ReportStatusEnum::DIKIRIM->value || $report->reportStatus->name === ReportStatusEnum::TERVERIFIKASI->value) {
            Log::info('Report already verified');
            $status['result'] = True;
            $status['message'] = 'Laporan sudah anda ajukan untuk verifikasi';

            broadcast(new ReportVerified($report->id, $status));
            return;
        }

        $status = $report->progres();

        // check all status is true
        if (in_array(false, $status, true)) {
            Log::info('Report not verified');
            // append status with result
            $status['message'] = 'Mohon maaf, Pengajuan verifikasi laporan gagal, silahkan periksa kembali data laporan anda';

            $status['result'] = false;
            broadcast(new ReportVerified($report->id, $status));
            return;
        }

        // append status with result
        Log::info('Report verified');
        $status['result'] = true;
        $status['message'] = 'Selamat!, Pengajuan verifikasi laporan berhasil';
        $report->report_status_id = 2;
        $report->save();

        broadcast(new ReportVerified($report->id, $status));
    }
}
