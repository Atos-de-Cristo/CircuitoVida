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



    public function mount($lessonId, $activityId, ActivityService $service)
    {
        $this->lessonId = $lessonId;
        $this->activityId = $activityId;

        if ($activityId) {
            $data = $service->find($activityId);
            $this->title = $data->title;
            $this->description = $data->description;
        }
    }

    public function render()
    {
        return view('livewire.event.activity.actions');
    }

    public function store(ActivityService $service)
    {
        $this->validate([ 'title' => 'required' ]);

        $request = [
            'id' => $this->activityId,
            'lesson_id' => $this->lessonId,
            'title' => $this->title,
            'description' => $this->description
        ];

        $service->store($request);

        $this->emit('refreshActivityList');
        $this->isOpenActivity = false;
        $this->resetInput();
    }

    private function resetInput()
    {
        $this->title = '';
        $this->description = '';
    }

    public function dellActivity(ActivityService $service)
    {
        $service->delete($this->activityId);
        $this->emit('refreshClassroom');
        $this->emit('refreshActivityList');
    }
}
