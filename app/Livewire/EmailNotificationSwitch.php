<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class EmailNotificationSwitch extends Component
{

    public User $user;
    public bool $notificationEmail;

    public function updatedNotificationEmail()
    {
        $this->user->update([
            'notification_email' => $this->notificationEmail,
        ]);
    }

    public function mount(User $user)
    {
        $this->user = $user;
        $this->notificationEmail = $user->notification_email;
    }

    public function render()
    {
        return view('livewire.email-notification-switch');
    }
}
