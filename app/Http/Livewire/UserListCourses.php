<?php

namespace App\Http\Livewire;

use App\Enums\InscriptionStatus;
use App\Services\EventService;
use App\Services\InscriptionService;

class UserListCourses extends Base
{
    public $user, $activity, $inscId, $transferCourseId, $courseId;
    public $isOpen = false;
    public $isOpenTransf = false;
    public $isOpenConfirmApprove = false;
    public $isOpenConfirmFail = false;
    public $cancellation_reason = '';

    public function getEventListProperty()
    {
        $eventService = new EventService;
        return $eventService->listActive();
    }

    public function getInscriptionServiceProperty()
    {
        return new InscriptionService;
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

    public function initTransfer($inscId)
    {
        $this->inscId = $inscId;
        $this->isOpenTransf = true;
    }

    public function approveStudent($inscId)
    {
        $this->inscId = $inscId;
        $this->isOpenConfirmApprove = true;
    }

    public function failStudent($inscId)
    {
        $this->inscId = $inscId;
        $this->isOpenConfirmFail = true;
    }

    public function handleStatusInscription($status)
    {
        $this->inscriptionService->update([
            'status' => $status,
            'cancellation_reason' => $this->cancellation_reason
        ], $this->inscId);

        $this->emit('refreshUserDetail');
        $this->isOpenConfirmApprove = false;
        $this->isOpenConfirmFail = false;
    }

    public function transfer()
    {
        $this->inscriptionService->update([
            'status' => InscriptionStatus::T->name
        ], $this->inscId);

        $data = [
            'user_id' => $this->user->id,
            'event_id' => $this->transferCourseId,
            'quantity' => 1,
            'amount' => '0',
            'status' => InscriptionStatus::L->name
        ];

        $this->inscriptionService->create($data);

        $this->emit('refreshUserDetail');
        $this->isOpenTransf = false;
    }
}
