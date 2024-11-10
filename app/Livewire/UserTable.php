<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;

class UserTable extends Component
{
    public $users;
    public $editingId = null;
    public $editingData = [];

    public function mount()
    {
        $this->loadUsers();
    }

    public function loadUsers()
    {
        $this->users = User::latest()->get();
    }

    public function startEditing($userId)
    {
        $user = User::find($userId);
        $this->editingId = $userId;
        $this->editingData = [
            'name' => $user->name,
            'email' => $user->email,
        ];
    }

    public function saveEdit()
    {
        $this->validate([
            'editingData.name' => 'required|min:2',
            'editingData.email' => 'required|email',
        ]);

        $user = User::find($this->editingId);
        $user->update($this->editingData);

        $this->editingId = null;
        $this->editingData = [];

        $this->loadUsers();

        session()->flash('message', 'Data berhasil diperbarui!');
    }

    public function cancelEdit()
    {
        $this->editingId = null;
        $this->editingData = [];
    }

    public function render()
    {
        return view('livewire.user-table');
    }
}
