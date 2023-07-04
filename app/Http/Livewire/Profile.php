<?php

namespace App\Http\Livewire;

use App\Enums\{ChurchRelationship, HouMeet, MaritalStatus, Schooling};
use App\Services\ProfileService;
use Livewire\Component;

class Profile extends Component
{
    public $form;

    public function getProfileServiceProperty()
    {
        return new ProfileService;
    }

    public function booted()
    {
        $this->form = $this->profileService->find();
    }

    public function render()
    {
        return view('livewire.user.profile');
    }

    public function getOptMaritalStatusProperty()
    {
        return MaritalStatus::cases();
    }

    public function getOptChurchRelationshipProperty()
    {
        return ChurchRelationship::cases();
    }

    public function getOptHouMeetProperty()
    {
        return HouMeet::cases();
    }

    public function getOptSchoolingProperty()
    {
        return Schooling::cases();
    }

    public function store()
    {
        $this->profileService->store($this->form);

        session()->flash('message', 'Perfil atualizado.');
    }
}
