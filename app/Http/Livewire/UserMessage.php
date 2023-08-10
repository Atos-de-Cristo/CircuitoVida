<?php

namespace App\Http\Livewire;

use App\Services\MessageService;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class UserMessage extends Base
{
    public $userId;

    public function mount($user=null)
    {
        $this->userId = $user;
    }

    public function getMessageServiceProperty()
    {
        return new MessageService;
    }

    public function getListMessageProperty()
    {
        return $this->messageService->listMessageUser($this->userId);
    }

    public function render()
    {
        return view('livewire.user.message');
    }

    public function send()
    {
        try {
            $this->resetErrors();
            $this->form['user_for'] = $this->userId;
            $this->messageService->send($this->form);
            $this->form = [];
        } catch (ValidationException $e) {
            $this->setErrorMessages($e->validator->errors());
        }
    }

    public function read(int $id)
    {
        $this->messageService->read($id);
        session()->flash('message', [
            'text' => 'Mensagem lida!',
            'type' => 'success',
        ]);
    }

    public function sendMessage($idSend)
    {
        $this->emit('openSendMessage', $idSend);
    }
}
