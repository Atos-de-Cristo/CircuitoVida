<?php

namespace App\Http\Livewire;

use App\Enums\{ChurchRelationship, HouMeet, MaritalStatus, Schooling};
use App\Services\ProfileService;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class Profile extends Component
{
    public $id, $cpf, $sex, $birth, $marital_status, $phone, $userId;
    public $leader, $date_baptism, $member, $church, $deficiency;

    public function getProfileServiceProperty()
    {
        return new ProfileService;
    }

    public function mount($userId = null)
    {
        $this->userId = $userId;
        if ($userId) {
            $data = $this->profileService->findUser($userId);
        }
        if ($data) {
            $this->id = $data['id'];
            $this->cpf = $data['cpf'];
            $this->sex = $data['sex'];
            $this->birth = $data['birth'];
            $this->marital_status = $data['marital_status'];
            $this->phone = $data['phone'];
            $this->deficiency = $data['deficiency'];
            $this->leader = $data['leader'];
            $this->date_baptism = $data['date_baptism'];
            $this->member = $data['member'];
            $this->church = $data['church'];
        }
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
        try {
            $request = [
                'id' => ($this->id) ? $this->id : null,
                'userId' => ($this->userId) ? $this->userId : null,
                'cpf' => $this->cpf,
                'sex' => $this->sex,
                'birth' => $this->birth,
                'marital_status' => $this->marital_status,
                'phone' => $this->phone,
                'deficiency' => $this->deficiency
            ];

            $this->profileService->store($request);

            session()->flash('message', [
                'text' => 'Perfil atualizado com sucesso.' ,
                'type' => 'success',
            ]);
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
