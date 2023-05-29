<?php

namespace App\Http\Livewire;

use App\Services\EventService;
use App\Services\FrequencyService;
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

    public function storeFrequency(FrequencyService $frequencyService)
    {
        $request = [];
        foreach ($this->users as $key => $data) {
            $dataConvert = json_decode($data);
            $request[$key]['user_id'] = $dataConvert->user_id;
            $request[$key]['inscription_id'] = $dataConvert->id;
            $request[$key]['event_id'] = $this->eventId;
            $request[$key]['lesson_id'] = $this->lessonId;
        }

        $frequencyService->create($request);

        $this->emit('closeModalFrequency');
    }
}
