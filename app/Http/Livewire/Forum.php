<?php

namespace App\Http\Livewire;

use App\Services\ForumService;
use Livewire\Component;

class Forum extends Component
{
    public $message = '', $lessonId;

    public function mount(int $lessonId)
    {
        $this->lessonId = $lessonId;
    }

    public function getForumServiceProperty()
    {
        return new ForumService;
    }

    public function getListForumProperty()
    {
        return $this->forumService->list($this->lessonId);
    }

    public function render()
    {
        return view('livewire.event.forum');
    }

    public function sendForum()
    {
        $this->forumService->send($this->message, $this->lessonId);
        $this->message = '';
    }
}
