<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class NotificationButton extends Component
{
    public $notifications = [];
    public $unreadCount = 0;

    public function mount()
    {
        /*$this->notifications = [*/
        /*    [*/
        /*        'id' => 1,*/
        /*        'title' => 'New Task Assigned',*/
        /*        'message' => 'You have been assigned a new task',*/
        /*        'time' => '5m ago',*/
        /*        'read' => false*/
        /*    ],*/
        /*    [*/
        /*        'id' => 2,*/
        /*        'title' => 'System Update',*/
        /*        'message' => 'System will be updated tonight',*/
        /*        'time' => '1h ago',*/
        /*        'read' => false*/
        /*    ]*/
        /*];*/

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
