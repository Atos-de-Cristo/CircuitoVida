<?php

namespace App\Http\Livewire;

use App\Services\MessageService;
use Livewire\Component;

class UserMessage extends Component
{
    public $message, $userId;

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
        $this->messageService->send([
            'message' => $this->message,
            'user_for' => $this->userId
        ]);

        session()->flash('message', 'Mensagem enviada!');
    }

    public function read(int $id)
    {
        $this->messageService->read($id);

        session()->flash('message', 'Mensagem lida!');
    }
}
