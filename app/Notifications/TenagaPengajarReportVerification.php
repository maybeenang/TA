<?php

namespace App\Notifications;

use App\Models\Report;
use Carbon\Carbon;
use Duijker\LaravelMercureBroadcaster\Broadcasting\Channel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TenagaPengajarReportVerification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $userId;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public Report $report,
    ) {}

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
            ->subject('Laporan berhasil terverifikasi')
            ->markdown('mail.tenaga-pengajar-report-verification', [
                'report' => $this->report,
                'url' => route('tenaga-pengajar.laporan.show', $this->report),
            ]);
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'report_id' => $this->report->id,
            'title' => 'Laporan berhasil terverifikasi',
            'message' => 'Selamat!, Laporan kelas ' . $this->report?->classRoom->fullName . ' telah berhasil terverifikasi.',
        ];
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        $this->userId = $notifiable->id;

        return new BroadcastMessage([
            'report_id' => $this->report->id,
            'title' => 'Laporan berhasil terverifikasi',
            'message' => 'Selamat!, Laporan kelas ' . $this->report?->classRoom->fullName . ' telah berhasil terverifikasi.',
            'time' => Carbon::now()->diffForHumans(),
        ]);
    }

    public function broadcastOn()
    {
        return new Channel('notification-user-' . $this->userId);
    }
}
