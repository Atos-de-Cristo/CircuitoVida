<?php

namespace App\Http\Livewire;

use App\Enums\InscriptionStatus;
use App\Services\EventService;
use App\Services\InscriptionService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DashboardUser extends Component
{
    public function render(EventService $service)
    {
        $eventAll = $service->getAll();
        return view('livewire.dashboard.user', compact('eventAll'));
    }

    public function insc(string $idEvent, InscriptionService $service){
        $data = [
            'user_id' => Auth::user()->id,
            'event_id' => $idEvent,
            'quantity' => 1,
            'amount' => '0',
            'status' => 'P'
        ];

        $service->create($data);

        return redirect()->route('inscription');
    }
}
