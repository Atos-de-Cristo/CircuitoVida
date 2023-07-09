<?php

namespace App\Http\Livewire;

use App\Services\MessageService;
use Livewire\Component;

class ListMessages extends Component
{
    public function getMessageServiceProperty()
    {
        return new MessageService;
    }

    public function getListMessageProperty()
    {
        return $this->messageService->listMessageUser();
    }

    public function render()
    {
        return view('livewire.user.list-messages');
    }
}
