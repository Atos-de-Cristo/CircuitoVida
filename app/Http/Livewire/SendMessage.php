<?php

namespace App\Http\Livewire;

use App\Services\EventService;
use App\Services\MessageService;
use App\Services\UserService;
use Livewire\Component;

class SendMessage extends Component
{
    public $message, $forUser, $forEvent;
    public $isOpenMessage = false;

    protected $listeners = [
        'openSendMessage' => 'openSendMessage',
        'openSendMessageRoom' => 'openSendMessageRoom'
    ];

    public function getMessageServiceProperty()
    {
        return new MessageService;
    }

    public function getUserServiceProperty()
    {
        return new UserService;
    }

    public function getEventServiceProperty()
    {
        return new EventService;
    }

    public function render()
    {
        return view('livewire.shared.send-message');
    }

    public function openSendMessage($id)
    {
        $this->forUser = $this->userService->find($id);
        $this->message = '';
        $this->isOpenMessage = true;
    }

    public function openSendMessageRoom($id)
    {
        $this->forEvent = $this->eventService->find($id);
        $this->message = '';
        $this->isOpenMessage = true;
    }

    public function send()
    {
        if ($this->forUser) {
            $this->messageService->send([
                'message' => $this->message,
                'user_for' => $this->forUser->id
            ]);
        }
        if ($this->forEvent) {
            $this->messageService->sendGroup([
                'message' => $this->message,
                'list_for' => $this->userService->listIdsEvent($this->forEvent->id)
            ]);
        }

        $this->isOpenMessage = false;
    }
}
