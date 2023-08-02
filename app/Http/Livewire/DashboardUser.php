<?php

namespace App\Http\Livewire;

use App\Enums\EventStatus;
use App\Services\EventService;
use App\Services\InscriptionService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class DashboardUser extends Component
{

    public function render(EventService $service)
    {
        $eventAll = $service->listActive();
        return view('livewire.dashboard.user', compact('eventAll'));
    }

    public function view(string $id)
    {
        redirect(route('eventManager', ['eventId' => $id]));
    }

    public function insc(string $idEvent, InscriptionService $service){
        try {
            if (Auth::user()->profile === null) {
                return redirect()->route('profile.show')->with('message', [
                    'text' => 'Preecha seu Perfil completo' ,
                    'type' => 'error',
                ]);

            }

            $data = [
                'user_id' => Auth::user()->id,
                'event_id' => $idEvent,
                'quantity' => 1,
                'amount' => '0',
                'status' => 'P'
            ];

            $service->create($data);

            return redirect()->route('inscription');
        } catch (ValidationException $e) {
            $errors = $e->validator->errors();

            $this->resetErrorBag();

            foreach ($errors->messages() as $field => $fieldErrors) {
                foreach ($fieldErrors as $error) {
                    $this->addError($field, $error);
                }
            }
        }
    }
}
