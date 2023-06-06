<?php

namespace App\Http\Livewire;

use App\Enums\InscriptionStatus;
use App\Services\InscriptionService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Inscription extends Component
{
    protected $listeners = ['refreshInsc' => '$refresh'];

    public function render(InscriptionService $service)
    {
        $dataAll = $service->getAll(['user_id' => Auth::user()->id]);
        return view('livewire.inscription.index', compact('dataAll'));
    }

    public function view(string $id)
    {
        redirect(route('eventManager', ['id' => $id]));
    }

    public function cancel(string $id, InscriptionService $service)
    {
        $service->update([
            'status' => InscriptionStatus::C->name,
        ], $id);

        $this->emit('refreshInsc');
    }
}
