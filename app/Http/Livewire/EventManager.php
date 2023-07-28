<?php

namespace App\Http\Livewire;

use App\Enums\InscriptionStatus;
use App\Services\{EventService, InscriptionService, ModuleService};
use Livewire\Component;
use Illuminate\Http\Request;
use Livewire\WithFileUploads;

class EventManager extends Component
{
    use WithFileUploads;

    protected $listeners = [
        'refreshManage' => '$refresh',
        'closeModalFrequency' => 'closeModalFrequency',
    ];

    public $eventId, $nameModule;
    public $user_id, $event_id, $date;

    public function mount(Request $request)
    {
        $this->eventId = $request->eventId;
    }

    public function render(EventService $eventService, ModuleService $moduleService)
    {
        $event = $eventService->find($this->eventId);
        $modules = $moduleService->getAll(['event_id' => $this->eventId]);
        return view('livewire.event.manager', compact('event', 'modules'));
    }

    public function sendMessage($idSend)
    {
        $this->emit('openSendMessage', $idSend);
    }

    public function sendRoom()
    {
        $this->emit('openSendMessageRoom', $this->eventId);
    }
}
