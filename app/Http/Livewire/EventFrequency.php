<?php

namespace App\Http\Livewire;

use App\Services\EventService;
use Livewire\Component;

class EventFrequency extends Component
{
    public $eventId, $lessonId;
    public array $users;

    public function mount($eventId, $lessonId)
    {
        $this->eventId = $eventId;
        $this->lessonId = $lessonId;
        $this->users = [];
    }

    public function render(EventService $eventService)
    {
        $event = $eventService->find($this->eventId);
        return view('livewire.event.frequency.create', compact('event'));
    }

    public function closeModalFrequency()
    {
        $this->emit('closeModalFrequency');
    }

    private function resetInputActivity()
    {
        // $this->titleActivity = '';
        // $this->type = '';
        // $this->option = '';
    }

    public function storeFrequency()
    {
        dd($this->users);
        // $request = [
        //     'event_id' => $this->eventId,
        //     'lesson_id' => $this->lessonId,
        //     'title' => $this->titleActivity,
        //     'type' => $this->type,
        //     'option' => $this->option
        // ];

        // $service->create($request);

        $this->resetInputActivity();
    }
}
