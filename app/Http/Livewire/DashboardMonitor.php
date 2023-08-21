<?php

namespace App\Http\Livewire;

use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DashboardMonitor extends Component
{
    public function getUserServiceProperty()
    {
        return new UserService;
    }

    public function render()
    {
        return view('livewire.dashboard.monitor');
    }

    public function getListEventsProperty()
    {
        return $this->userService->find(Auth::user()->id)->monitors;
    }

    public function view(string $id)
    {
        redirect(route('eventManager', ['eventId' => $id]));
    }
}
