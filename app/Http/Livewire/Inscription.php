<?php

namespace App\Http\Livewire;

use App\Enums\InscriptionStatus;
use App\Services\InscriptionService;
use Livewire\Component;

class Inscription extends Component
{
    protected $listeners = ['refreshComponent' => '$refresh'];

    public function render(InscriptionService $service)
    {
        $dataAll = $service->getAll();
        return view('livewire.inscription.index', compact('dataAll'));
    }

    public function ticket(string $id){

    }

    public function cancel(string $id, InscriptionService $service){
        $service->update([
            'status' => InscriptionStatus::C->name,
        ], $id);

        $this->emit('refreshComponent');
    }
}
