<?php

namespace App\Livewire;

use App\Services\SidebarService;
use Livewire\Component;

class AppSidebar extends Component
{

    private SidebarService $sidebarService;

    public $badgeCount = [];

    public $testing = 1;

    public function boot(SidebarService $sidebarService)
    {
        $this->sidebarService = $sidebarService;
    }

    public function refreshBadgeCount()
    {
        $this->badgeCount = $this->sidebarService->getBadgeCount();
        $this->testing++;
    }

    public function mount()
    {
        $this->badgeCount = $this->sidebarService->getBadgeCount();
    }



    public function render()
    {
        return view('livewire.app-sidebar');
    }
}
