<?php

namespace App\Http\Livewire;

use App\Services\EventService;
use App\Services\UserService;
use Livewire\Component;

class EventMonitors extends Component
{
    public $eventId, $monitors;
    public $search = '';

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

    public function closeModalMonitors()
    {
        $this->emit('closeModalMonitors');
    }

    public function storeMonitors(EventService $eventService)
    {

        $eventService->update(['monitors' => $this->monitors], $this->eventId);

        $this->emit('closeModalMonitors');
    }
}
