<?php

namespace App\Http\Livewire;

use App\Enums\{ChurchRelationship, HouMeet, MaritalStatus, Schooling};
use App\Services\ProfileService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class Profile extends Component
{
    public $cpf, $sex, $birth, $marital_status, $phone, $userId;
    public $leader, $date_baptism, $member, $church, $deficiency;
    public $trintaSemanas = '0';
    public $trintaSemanasData;
    public $retiroInspiracao = '0';
    public $retiroInspiracaoData;
    public $showAdminMessage = false;

    public function getProfileServiceProperty()
    {
        return new ProfileService;
    }

    public function mount($userId = null)
    {
        $this->userId = $userId;
        if ($userId) {
            $data = $this->profileService->findUser($userId);
        } else {
            $data = $this->profileService->find();
        }
        if ($data) {
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
            $this->trintaSemanas = isset($data['trinta_semanas']) ? ($data['trinta_semanas'] ? '1' : '0') : '0';
            $this->trintaSemanasData = $data['trinta_semanas_data'] ?? null;
            $this->retiroInspiracao = isset($data['retiro_inspiracao']) ? ($data['retiro_inspiracao'] ? '1' : '0') : '0';
            $this->retiroInspiracaoData = $data['retiro_inspiracao_data'] ?? null;
        }
    }

    public function updatedTrintaSemanas($value): void
    {
        if ($value !== '1') {
            $this->trintaSemanasData = null;
        }
    }

    public function updatedRetiroInspiracao($value): void
    {
        if ($value !== '1') {
            $this->retiroInspiracaoData = null;
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
            // Verifica se o usuário está tentando alterar a data de membresia sem ser admin
            if (!auth()->user()->can('admin') && $this->member !== null && $this->member !== $this->profileService->find()['member']) {
                throw ValidationException::withMessages([
                    'member' => 'A data de membresia só pode ser alterada pela administração da igreja.'
                ]);
            }

            $validator = Validator::make(
                [
                    'trintaSemanas' => $this->trintaSemanas,
                    'trintaSemanasData' => $this->trintaSemanasData,
                    'retiroInspiracao' => $this->retiroInspiracao,
                    'retiroInspiracaoData' => $this->retiroInspiracaoData,
                ],
                [
                    'trintaSemanasData' => 'nullable|date|required_if:trintaSemanas,1',
                    'retiroInspiracaoData' => 'nullable|date|required_if:retiroInspiracao,1',
                ],
                [
                    'trintaSemanasData.required_if' => 'Informe a data do 30 semanas.',
                    'trintaSemanasData.date' => 'Informe uma data válida para o 30 semanas.',
                    'retiroInspiracaoData.required_if' => 'Informe a data do Retiro Inspiração.',
                    'retiroInspiracaoData.date' => 'Informe uma data válida para o Retiro Inspiração.',
                ]
            );
            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $request = [
                'userId' => ($this->userId) ? $this->userId : null,
                'cpf' => $this->cpf,
                'sex' => $this->sex,
                'birth' => $this->birth,
                'marital_status' => $this->marital_status,
                'phone' => $this->phone,
                'deficiency' => $this->deficiency,
                'leader' => $this->leader,
                'date_baptism' => $this->date_baptism,
                'member' => $this->member,
                'church' => $this->church,
                'trinta_semanas' => (bool) ($this->trintaSemanas ?? false),
                'trinta_semanas_data' => ((bool) ($this->trintaSemanas ?? false)) ? $this->trintaSemanasData : null,
                'retiro_inspiracao' => (bool) ($this->retiroInspiracao ?? false),
                'retiro_inspiracao_data' => ((bool) ($this->retiroInspiracao ?? false)) ? $this->retiroInspiracaoData : null,
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
