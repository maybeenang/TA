<?php

namespace App\Notifications;

use App\Enums\RolesEnum;
use App\Models\Report;
use Carbon\Carbon;
use Duijker\LaravelMercureBroadcaster\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Laravel\Reverb\Loggers\Log;

class AdminReportVerification extends Notification implements ShouldBroadcast
{
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
        if ($notifiable->hasRole(RolesEnum::GKMP->value)) {
            $url = 'gkmp.laporan.verifikasi.edit';
        } elseif ($notifiable->hasRole(RolesEnum::KAPRODI->value)) {
            $url = 'kaprodi.laporan.verifikasi.edit';
        } else {
            $url = 'admin.laporan.verifikasi.edit';
        }

        return (new MailMessage)
            ->subject('Verifikasi Laporan')
            ->markdown(
                'mail.admin-report-verification',
                [
                    'report' => $this->report,
                    'url' => route($url, $this->report),
                ]
            );
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'report_id' => $this->report->id,
            'title' => 'Verifikasi Laporan',
            'message' => 'Laporan kelas ' . $this->report->classRoom->fullName . ' telah dikirim dan menunggu untuk diverifikasi.',
        ];
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        $this->userId = $notifiable->id;
        return new BroadcastMessage([
            'report_id' => $this->report->id,
            'title' => 'Verifikasi Laporan',
            'message' => 'Laporan kelas ' . $this->report->classRoom->fullName . ' telah dikirim dan menunggu untuk diverifikasi.',
            // carbon diff for human now
            'time' => Carbon::now()->diffForHumans(),
        ]);
    }

    public function broadcastOn()
    {
        return new Channel('notification-user-' . $this->userId);
    }
}
