<?php

namespace App\Http\Livewire;

use App\Enums\InscriptionStatus;
use App\Services\EventService;
use App\Services\InscriptionService;

class UserListCourses extends Base
{
    public $user, $activity, $courseId, $transferCourseId;
    public $isOpen = false;
    public $isOpenTransf = false;

    public function getEventListProperty()
    {
        $eventService = new EventService;
        return $eventService->listActive();
    }

    public function mount($user=null, $activity=null)
    {
        $this->user = $user;
        $this->activity = $activity;
    }

    public function render()
    {
        return view('livewire.user.list-courses');
    }

    public function store()
    {
        $inscriptionService = new InscriptionService;

        $data = [
            'user_id' => $this->user->id,
            'event_id' => $this->courseId,
            'quantity' => 1,
            'amount' => '0',
            'status' => InscriptionStatus::L->name
        ];

        $inscriptionService->create($data);

        $this->emit('refreshUserDetail');
        $this->isOpen = false;
    }

    public function initTransfer($courseId)
    {
        $this->courseId = $courseId;
        $this->isOpenTransf = true;
    }

    public function transfer()
    {
        dd($this->courseId, $this->transferCourseId);
    }
}
