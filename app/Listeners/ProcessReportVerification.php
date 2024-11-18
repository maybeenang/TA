<?php

namespace App\Listeners;

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


        $status = $report->progres();
        Log::info('Report status: ' . json_encode($status));

        // check if report status id is 2
        if ($report->report_status_id === 2) {
            Log::info('Report already verified');
            $status['result'] = false;
            $status['message'] = 'Mohon maaf, Laporan sudah anda ajukan untuk verifikasi';

            broadcast(new ReportVerified($report->id, $status));
            return;
        }

        // check all status is true
        if (in_array(false, $status, true)) {
            Log::info('Report not verified');
            // append status with result
            $status['message'] = 'Mohon maaf, Pengajuan verifikasi laporan gagal, silahkan periksa kembali data laporan anda, Adapun data yang tidak sesuai adalah';

            $status['errors'] = array_filter($status, fn($value) => $value === false);
            // get all keys from errors
            $status['errors'] = array_keys($status['errors']);
            // convert to normal text
            $status['errors'] = array_map(fn($value) => $this->reportService->convertCamelCase($value), $status['errors']);

            $status['result'] = false;
            broadcast(new ReportVerified($report->id, $status));
            return;
        }

        // append status with result
        $status['result'] = true;
        Log::info('Report verified');
        $status['message'] = 'Selamat!, Pengajuan verifikasi laporan berhasil';
        $report->report_status_id = 2;
        $report->save();

        broadcast(new ReportVerified($report->id, $status));
    }
}
