<?php

namespace App\Http\Livewire;
use App\Services\InscriptionService;
use Livewire\Component;

class EventAlunos extends Component
{

    public $event_id;

    public function mount($id)
    {
        $this->event_id = $id;
    }

    public $search = '';
    public function render(InscriptionService $service)
    {
        $inscriptions = $service->getAllStudent($this->search, $this->event_id);
        return view('livewire.event.aluno.manager', compact('inscriptions'));
    }

    public function sendMessage($idSend)
    {
        $this->emit('openSendMessage', $idSend);
    }
}
