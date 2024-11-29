<?php

namespace App\Notifications;

use App\Models\Report;
use Carbon\Carbon;
use Duijker\LaravelMercureBroadcaster\Broadcasting\Channel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Laravel\Reverb\Loggers\Log;

class AdminReportVerification extends Notification implements ShouldQueue, ShouldBroadcast
{
    use Queueable;

    protected $userId;

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
        return (new MailMessage)->markdown('mail.admin-report-verification');
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'report_id' => $this->report->id,
            'title' => 'Verifikasi Laporan',
            'message' => 'Laporan baru telah dikirim dan menunggu verifikasi.',
        ];
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        $this->userId = $notifiable->id;
        return new BroadcastMessage([
            'report_id' => $this->report->id,
            'title' => 'Verifikasi Laporan',
            'message' => 'Laporan baru telah dikirim dan menunggu verifikasi.',
            // carbon diff for human now
            'time' => Carbon::now()->diffForHumans(),
        ]);
    }

    public function broadcastOn()
    {
        return new Channel('notification-user-' . $this->userId);
    }
}
