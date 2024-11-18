<?php

namespace App\Livewire;

use Livewire\Component;

class NotificationButton extends Component
{
    public $notifications = [];
    public $unreadCount = 0;

    public function mount()
    {
        // Contoh data, sesuaikan dengan model/database Anda
        $this->notifications = [
            [
                'id' => 1,
                'title' => 'New Task Assigned',
                'message' => 'You have been assigned a new task',
                'time' => '5m ago',
                'read' => false
            ],
            [
                'id' => 2,
                'title' => 'System Update',
                'message' => 'System will be updated tonight',
                'time' => '1h ago',
                'read' => false
            ]
        ];

        $this->unreadCount = collect($this->notifications)
            ->where('read', false)
            ->count();
    }

    public function markAsRead($notificationId)
    {
        // Implementasi mark as read
        collect($this->notifications)->map(function ($notification) use ($notificationId) {
            if ($notification['id'] == $notificationId) {
                $notification['read'] = true;
            }
            return $notification;
        });

        $this->unreadCount = collect($this->notifications)
            ->where('read', false)
            ->count();
    }

    public function markAllAsRead()
    {
        $this->notifications = collect($this->notifications)->map(function ($notification) {
            $notification['read'] = true;
            return $notification;
        })->toArray();

        $this->unreadCount = 0;
    }

    public function render()
    {
        return view('livewire.notification-button');
    }
}
