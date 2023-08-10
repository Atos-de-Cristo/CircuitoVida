<?php

namespace App\Http\Livewire;

use App\Services\MessageService;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class UserMessage extends Component
{
    public $message = '', $userId;

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
            $this->messageService->send([
                'message' => $this->message,
                'user_for' => $this->userId
            ]);
            $this->message = '';
        } catch (ValidationException $e) {
            $errors = $e->validator->errors();
            $this->resetErrorBag();
            foreach ($errors->messages() as $field => $fieldErrors) {
                if ($field != 'message') {
                    Session::flash('message', $fieldErrors);
                }
                foreach ($fieldErrors as $error) {
                    $this->addError($field, $error);
                }
            }
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
