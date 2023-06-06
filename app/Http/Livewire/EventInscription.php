<?php

namespace App\Http\Livewire;

use App\Enums\EventStatus;
use App\Enums\InscriptionStatus;
use App\Services\EventService;
use App\Services\InscriptionService;
use Livewire\Component;

class EventInscription extends Component
{
    public $isUser = false;
    public $userInscription;

    protected $listeners = ['refreshInscription' => '$refresh'];

    public function render(EventService $service)
    {
        $dataAll = $service->getAll();
        return view('livewire.event.inscription', compact("dataAll"));
    }

    public function close(string $id, EventService $service){
        $service->update([
            'status' => EventStatus::E->name,
        ], $id);

        $this->emit('refreshInscription');
    }

    public function open(string $id, EventService $service){
        $service->update([
            'status' => EventStatus::A->name,
        ], $id);

        $this->emit('refreshInscription');
    }

    public function viewInsc(string $id, InscriptionService $inscriptionService) {
        $this->userInscription = $inscriptionService->getAll(['event_id' => $id]);
        $this->isUser = true;
    }

    public function closeModal(){
        $this->isUser = false;
        $this->userInscription = '';
    }

    public function approveInscription(string $id, InscriptionService $inscriptionService){
        $inscriptionService->update([
            'status' => InscriptionStatus::L->name,
        ], $id);

        $this->userInscription = $inscriptionService->getAll(['event_id' => $id]);
    }

    public function disapproveInscription(string $id, InscriptionService $inscriptionService){
        $inscriptionService->update([
            'status' => InscriptionStatus::C->name,
        ], $id);

        $this->userInscription = $inscriptionService->getAll(['event_id' => $id]);
    }
}
