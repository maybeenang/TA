<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class NotificationButton extends Component
{
    public $notifications = [];
    public $unreadCount = 0;

    public function mount()
    {
        $this->notifications = Auth::user()->notifications->map(function ($notification) {
            return [
                'id' => $notification->id,
                'title' => $notification->data['title'] ?? '',
                'message' => $notification->data['message'] ?? '',
                'time' => $notification->created_at->diffForHumans(),
                'read' => $notification->read_at !== null
            ];
        })->toArray();

        $this->unreadCount = collect($this->notifications)
            ->where('read', false)
            ->count();
    }

    public function markAsRead($notificationId)
    {
        $notification = Auth::user()->notifications->where('id', $notificationId)->first();
        $notification->markAsRead();
        $this->notifications = collect($this->notifications)->map(function ($notification) use ($notificationId) {
            if ($notification['id'] == $notificationId) {
                $notification['read'] = true;
            }
            return $notification;
        })->toArray();

        $this->unreadCount = collect($this->notifications)
            ->where('read', false)
            ->count();
    }

    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        $this->notifications = collect($this->notifications)->map(function ($notification) {
            $notification['read'] = true;
            return $notification;
        })->toArray();
        $this->unreadCount = 0;
    }

    public function clearAllNotifications()
    {
        Auth::user()->notifications()->delete();
        $this->notifications = [];
        $this->unreadCount = 0;
    }

    public function receiveNotification($notification)
    {
        dump($notification);
        array_unshift($this->notifications, [
            'id' => $notification['id'],
            'title' => $notification['title'],
            'message' => $notification['message'],
            'time' => $notification['time'],
            'read' => false
        ]);

        $this->unreadCount++;
    }


    public function render()
    {
        return view('livewire.notification-button');
    }
}
