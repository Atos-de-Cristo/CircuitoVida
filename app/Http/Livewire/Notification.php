<?php

namespace App\Http\Livewire;

use App\Services\MessageService;
use Livewire\Component;

class Notification extends Component
{
    protected $listeners = ['refreshNotification' => '$refresh'];

    public function getMessageServiceProperty()
    {
        return new MessageService;
    }

    public function getListMessageProperty()
    {
        return $this->messageService->listMessageUnread();
    }

    public function render()
    {
        return view('livewire.dashboard.notification');
    }

    public function read(int $id)
    {
        $this->messageService->read($id);
        $this->emit('refreshNotification');
        redirect()->to('messages');
    }
}
