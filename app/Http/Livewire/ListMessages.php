<?php

namespace App\Http\Livewire;

use App\Services\MessageService;
use Livewire\Component;
use Livewire\WithPagination;
class ListMessages extends Component
{
    use WithPagination;
    public $search = '';

    public function getMessageServiceProperty()
    {
        return new MessageService;
    }

    public function getListMessageProperty()
    {
        return $this->messageService->listMessageUser(null, $this->search);
    }

    public function render()
    {
        return view('livewire.user.list-messages');
    }

    public function search()
    {
        $this->resetPage();
    }

    public function read(int $id)
    {
        $this->messageService->read($id);

        session()->flash('message', 'Mensagem lida!');
    }

    public function sendMessage($idSend)
    {
        $this->emit('openSendMessage', $idSend);
    }
}
