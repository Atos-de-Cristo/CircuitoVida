<?php

namespace App\Http\Livewire;

use App\Services\QuestionService;
use Illuminate\Http\Request;
use Livewire\Component;

class EventActivityQuestion extends Component
{
    public $title;
    public $type = 'aberta';
    public $options = [];
    public $atvId;

    public function boot(Request $request)
    {
        $this->atvId = $request->id;
    }

    public function render()
    {
        return view('livewire.event.activity.question');
    }

    public function addOption()
    {
        $this->options[] = ['text' => '', 'correct' => false];
    }

    public function removeOption($index)
    {
        unset($this->options[$index]);
        $this->options = array_values($this->options);
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
