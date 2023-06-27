<?php

namespace App\Http\Livewire;

use App\Services\EventService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Livewire\Component;

class EventMonitors extends Component
{
    public $eventId, $monitors;
    public $search = '';
    public $isOpenMonitors = false;

    public function boot(Request $request)
    {
        $this->eventId = $request->eventId;
    }

    public function mount(EventService $service)
    {
        $event = $service->find($this->eventId);
        $this->monitors = $event->monitors->pluck('id')->toArray();
    }

    public function render(UserService $userService)
    {
        $optMonitors = $userService->getMonitorsFiltered($this->search);
        return view('livewire.event.monitors.manager', compact('optMonitors'));
    }

    public function storeMonitors(EventService $eventService)
    {
        $request = [
            'id' => $this->eventId,
            'monitors' => $this->monitors
        ];

        $eventService->store($request);

        $this->emit('refreshManage');
        $this->isOpenMonitors = false;
    }
}
