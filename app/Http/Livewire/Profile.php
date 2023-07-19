<?php

namespace App\Http\Livewire;

use App\Enums\{ChurchRelationship, HouMeet, MaritalStatus, Schooling};
use App\Services\ProfileService;
use Livewire\Component;

class Profile extends Component
{
    public $form;

    protected $rules = [
        'form.cpf'=> 'required',
        'form.rg'=> 'required',
        'form.sex'=> 'required',
        'form.birth'=> 'required',
        'form.marital_status'=> 'required',
        'form.date_wedding'=> 'required',
        'form.marital_status'=> 'required',
        'form.zip_code'=> 'required',
        'form.address'=> 'required',
        'form.number'=> 'required',
        'form.complement'=> 'required',
        'form.district'=> 'required',
        'form.city'=> 'required',
        'form.uf'=> 'required',
        'form.cell_phone'=> 'required',
        'form.church_relationship'=> 'required',
        'form.entry_date'=> 'required',
        'form.hou_meet'=> 'required',
        'form.baptized'=> 'required',
        'form.accepted_jesus'=> 'required',
        'form.leader'=> 'required',
        'form.pastor'=> 'required',
        'form.Schooling'=> 'required',
        'form.profession'=> 'required',
    ];

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
        $this->validate();

        $this->profileService->store($this->form);

        session()->flash('message', [
            'text' => 'Perfil atualizado com sucesso.' ,
            'type' => 'success',
        ]);
    }
}
