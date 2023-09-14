<?php

namespace App\Http\Livewire;

use App\Enums\InscriptionStatus;
use App\Services\InscriptionService;
use App\Services\MessageService;
use Livewire\Component;

class EventStudentStatus extends Component
{
    public $user;
    public $isOpen = false;
    public $inscriptionId;
    public $activityStatus;
    public $absenceCount;
    public $isCancelled = false;

    public function getServiceProperty()
    {
        return new InscriptionService;
    }

    public function getMessageServiceProperty()
    {
        return new MessageService;
    }

    public function mount($student, $activityStatus, $absenceCount, $inscriptionId)
    {
        $this->user = $student;
        $this->activityStatus = $activityStatus;
        $this->absenceCount = $absenceCount;
        $this->inscriptionId = $inscriptionId;
    }

    public function render()
    {
        $key = rand();
        return view('livewire.event.student.status', compact('key'));
    }

    public function handleShutdown()
    {
        $this->service->update(['status' => InscriptionStatus::C->name], $this->inscriptionId);
        $this->messageService->sendAdmin(
            'Cancelado a inscrição do aluno '.$this->user->name
        );
        $this->emit('refreshManage');
        $this->isOpen = false;
    }
}
