<?php

namespace App\Http\Livewire;

use App\Services\ActivityService;
use Livewire\Component;
use Livewire\WithFileUploads;

class EventActivityActions extends Component
{
    use WithFileUploads;

    private $service;
    public $lessonId, $activityId;
    public $title, $description;
    public $isOpenQuestions;
    public $isOpenActivity = false;

    public function __construct()
    {
        $this->service = new ActivityService;
    }

    public function mount($lessonId, $activityId)
    {
        $this->lessonId = $lessonId;
        $this->activityId = $activityId;

        if ($activityId) {
            $data = $this->service->find($activityId);
            $this->title = $data->title;
            $this->description = $data->description;
        }
    }

    public function render()
    {
        return view('livewire.event.activity.actions');
    }

    public function store()
    {
        $this->validate([ 'title' => 'required' ]);

        $request = [
            'id' => $this->activityId,
            'lesson_id' => $this->lessonId,
            'title' => $this->title,
            'description' => $this->description
        ];

        $this->service->store($request);

        $this->emit('refreshActivityList');
        $this->isOpenActivity = false;
        $this->resetInput();
    }

    private function resetInput()
    {
        $this->title = '';
        $this->description = '';
    }

    public function dellActivity()
    {
        $this->service->delete($this->activityId);
        $this->emit('refreshClassroom');
        $this->emit('refreshActivityList');
    }
}
