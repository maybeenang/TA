<?php

namespace App\Listeners;

use App\Enums\RolesEnum;
use App\Events\ReportVerified;
use App\Models\Report;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class SendAdminReportVerifiedNotif
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
    public function handle(ReportVerified $event): void
    {

        Log::info('notifikasi admin');
        $admins = User::role(RolesEnum::ADMIN->value)->get();
        $report = Report::find($event->reportId);

        foreach ($admins as $admin) {
            Log::info('Sending report verification notification to admin' . $admin->id);
            $admin->notify(new \App\Notifications\AdminReportVerification($report, $admin->id));
        }
    }
}
