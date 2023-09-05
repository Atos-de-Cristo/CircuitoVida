<?php

namespace App\Http\Livewire;

use App\Services\InscriptionService;
use Livewire\Component;

class EventStudentStatus extends Component
{
    public $user;
    public $isOpen = false;
    public $activityStatus;
    public $absenceCount;

    public function getServiceProperty()
    {
        return new InscriptionService;
    }

    public function mount($aluno, $activityStatus, $absenceCount)
    {
        $this->user = $aluno;
        $this->activityStatus = $activityStatus;
        $this->absenceCount = $absenceCount;
    }

    public function render()
    {
        $key = rand();
        // $aluno = $this->service->getAllStudent('', null, $this->inscriptionId);
        return view('livewire.event.student.status', compact('key'));
    }

    public function handleShutdown()
    {
        $this->isOpen = false;
    }
}
