<?php

namespace App\Http\Livewire;

use App\Services\ActivityService;
use App\Services\LessonService;
use Livewire\Component;
use Livewire\WithFileUploads;

class EventActivityActions extends Component
{
    use WithFileUploads;

    private $service;
    public $lessonId, $activityId;
    public $title, $description;
    public $type = false;
    public $isOpenQuestions;
    public $userListActivity = [];
    public $inscriptions = [];
    public $isOpenActivity = false;
    private $activity;

    public function getActivityServiceProperty()
    {
        return new ActivityService;
    }

    public function getLessonServiceProperty()
    {
        return new LessonService;
    }

    public function mount($lessonId, $activityId)
    {
        $this->lessonId = $lessonId;
        $this->activityId = $activityId;
    }

    public function render()
    {
        return view('livewire.event.activity.actions');
    }

    public function openModal()
    {
        if ($this->activityId) {
            $this->activity = $this->activityService->find($this->activityId);
            $this->title = $this->activity->title;
            $this->description = $this->activity->description;
            $this->type = $this->activity->type == 'G' ? false : true;
            if ($this->activity->type == 'E') {
                $this->inscriptions = $this->lessonService->find($this->lessonId)->event->inscriptions;
                $this->userListActivity = $this->activity->users->pluck('id')->toArray();
            }
        }
        $this->isOpenActivity = true;
    }

    public function closeModal()
    {
        $this->isOpenActivity = false;
    }

    public function updated()
    {
        if ($this->type) {
            $this->inscriptions = $this->lessonService->find($this->lessonId)->event->inscriptions;
        }
    }

    public function store(ActivityService $service)
    {
        $this->validate([ 'title' => 'required' ]);

        $request = [
            'id' => $this->activityId,
            'lesson_id' => $this->lessonId,
            'title' => $this->title,
            'description' => $this->description,
            'type' => ($this->type) ? 'E' : 'G',
            'userListActivity' => $this->userListActivity
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
