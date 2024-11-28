<?php

namespace App\Notifications;

use App\Models\Report;
use Duijker\LaravelMercureBroadcaster\Broadcasting\Channel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class ReportStatusUpdated extends Notification implements ShouldQueue, ShouldBroadcast
{
    use Queueable;

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
        return ['mail', 'database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)->markdown('mail.report-status-updated');
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
            'message' => 'Status laporan anda berubah menjadi ' . $this->report->reportStatus->name,
        ];
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'report_id' => $this->report->id,
            'title' => 'Status Laporan anda berubah',
            'message' => 'Status laporan anda berubah menjadi ' . $this->report->reportStatus->name,
        ]);
    }

    public function broadcastOn()
    {
        $userId = $this->report->userId;
        return new Channel('notification-user-' . $userId, true);
    }
}
