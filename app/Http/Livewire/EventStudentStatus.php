<?php

namespace App\Http\Livewire;

use App\Enums\InscriptionStatus;
use App\Services\InscriptionService;
use App\Services\MessageService;
use Livewire\Component;

class EventStudentStatus extends Base
{
    public $user;
    public $isOpen = false;
    public $inscriptionId;
    public $activityStatus;
    public $absenceCount;
    public $eventId;
    public $confirmHandleStatus = '';
    public $cancellation_reason = '';

    public function getServiceProperty()
    {
        return new InscriptionService;
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->confirmHandleStatus = '';
        $this->cancellation_reason = '';
    }

    public function getMessageServiceProperty()
    {
        return new MessageService;
    }

    public function mount($student, $activityStatus, $absenceCount, $inscriptionId, $eventId)
    {
        $this->user = $student;
        $this->activityStatus = $activityStatus;
        $this->absenceCount = $absenceCount;
        $this->inscriptionId = $inscriptionId;
        $this->eventId = $eventId;
    }

    public function sendMessage($idSend)
    {
        $this->emit('openSendMessage', $idSend);
    }

    public function render()
    {
        $key = rand();
        return view('livewire.event.student.status', compact('key'));
    }

    public function toggleInscription()
    {
        $this->service->update([
            'cancellation_reason' => $this->cancellation_reason,
            'status' => $this->confirmHandleStatus
        ],
            $this->inscriptionId
        );
        $this->messageService->sendAdmin(
            'Alteração de status do aluno '.$this->user->name. ', motivo: '.$this->cancellation_reason
        );
        $this->emit('refreshManage');
        $this->isOpen = false;
    }
}
