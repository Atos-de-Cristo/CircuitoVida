<?php

namespace App\Http\Livewire;

use App\Services\QuestionService;
use Livewire\Component;

class EventActivityQuestion extends Component
{
    public $type, $title;
    public $atvId;

    public function mount($atvId)
    {
        $this->atvId = $atvId;
    }

    public function render()
    {
        return view('livewire.event.activity.question');
    }

    public function close()
    {
        $this->emit('closeModalQuestions');
    }

    public function store(QuestionService $questionService)
    {
        $this->validate([
            'type' => 'required',
            'title' => 'required',
        ]);

        $request = [
            'activity_id' => $this->atvId,
            'type' => $this->type,
            'title' => $this->title,
        ];

        $questionService->create($request);

        $this->resetInput();
        $this->emit('refreshActivity');
        $this->close();
    }

    public function resetInput()
    {
        $this->type = '';
        $this->title = '';
    }
}
