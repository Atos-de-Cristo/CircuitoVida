<?php

namespace App\Http\Livewire;

use App\Enums\EventStatus;
use App\Services\EventService;
use App\Services\InscriptionService;
use Livewire\Component;

class EventInscription extends Component
{
    protected $listeners = ['refreshComponent' => '$refresh'];
    public $isUser = false;
    public $userInscription;

    public function render(EventService $service)
    {
        $dataAll = $service->getAll();
        return view('livewire.event.inscription', compact("dataAll"));
    }

    public function close(string $id, EventService $service){
        $service->update([
            'status' => EventStatus::E->name,
        ], $id);

        $this->emit('refreshComponent');
    }

    public function open(string $id, EventService $service){
        $service->update([
            'status' => EventStatus::A->name,
        ], $id);

        $this->emit('refreshComponent');
    }

    public function viewInsc(string $id, InscriptionService $inscriptionService) {
        $this->userInscription = $inscriptionService->getAll(['event_id' => $id]);
        $this->isUser = true;
    }

    public function closeModal(){
        $this->isUser = false;
        $this->userInscription = '';
    }
}
