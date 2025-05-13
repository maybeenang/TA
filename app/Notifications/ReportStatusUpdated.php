<?php

namespace App\Notifications;

use App\Models\Report;
use Carbon\Carbon;
use Duijker\LaravelMercureBroadcaster\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class ReportStatusUpdated extends Notification implements ShouldBroadcast
{
    /**
     * Create a new notification instance.
     */
    public function __construct(
        public Report $report,
    ) {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        $channel =  ['database', 'broadcast'];

        if ($notifiable->notification_email) {
            $channel[] = 'mail';
        }

        return $channel;
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Status Laporan berubah')
            ->markdown('mail.report-status-updated', [
                'report' => $this->report,
                'url' => route('tenaga-pengajar.laporan.show', $this->report),
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'report_id' => $this->report->id,
            'title' => 'Status Laporan anda berubah',
            'message' => 'Laporan kelas ' . $this->report?->classRoom?->fullName . ' berubah menjadi ' . $this->report->reportStatus->name,
        ];
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'report_id' => $this->report->id,
            'title' => 'Status Laporan anda berubah',
            'message' => 'Laporan kelas ' . $this->report?->classRoom?->fullName . ' berubah menjadi ' . $this->report->reportStatus->name,
            // carbon diff for human now
            'time' => Carbon::now()->diffForHumans(),
        ]);
    }

    public function broadcastOn()
    {
        $userId = $this->report->userId;
        return new Channel('notification-user-' . $userId);
    }
}
