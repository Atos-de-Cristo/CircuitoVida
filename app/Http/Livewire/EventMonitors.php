<?php

namespace App\Http\Livewire;

use App\Services\EventService;
use App\Services\UserService;
use Livewire\Component;

class EventMonitors extends Component
{

    public $eventId, $monitors;
    public $search = '';
    public $isOpenMonitors = false;

    public function mount($eventId, EventService $service)
    {
        $this->eventId = $eventId;
        $event = $service->find($eventId);
        $this->monitors = $event->monitors->pluck('id')->toArray();
    }

    public function render(UserService $userService)
    {
        $optMonitors = $userService->getMonitorsFiltered($this->search);
        return view('livewire.event.monitors.manager', compact('optMonitors'));
    }
    public function openModalMonitors()
    {
        $this->isOpenMonitors = true;
    }

    public function closeModalMonitors()
    {
        $this->isOpenMonitors = false;
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
