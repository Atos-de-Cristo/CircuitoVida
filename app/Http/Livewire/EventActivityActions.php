<?php

namespace App\Http\Livewire;

use App\Services\ActivityService;
use App\Services\LessonService;
use Livewire\Component;
use Livewire\WithFileUploads;

class EventActivityActions extends Component
{
    use WithFileUploads;
    public $search = '';
    private $service;
    public $lessonId, $activityId;
    public $title, $description;
    public $start_date = null;
    public $end_date = null;
    public $type = false;
    public $isOpenQuestions;
    public $userListActivity = [];
    public $inscriptions = [];
    public $isOpenActivity = false;
    public $activity;

    protected $listeners = ['eventoExclusaoRealizada' => 'dellActivity'];

    public function getActivityServiceProperty()
    {
        return new ActivityService;
    }

    public function getLessonServiceProperty()
    {
        $lessonService = new LessonService;
        return $lessonService->find($this->lessonId);
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
            $this->start_date = $this->activity->start_date ? date('Y-m-d H:i:s', strtotime($this->activity->start_date)) : $this->lessonService->start_date;
            $this->end_date = $this->activity->end_date ? date('Y-m-d H:i:s', strtotime($this->activity->end_date)) : $this->lessonService->end_date;
            $this->description = $this->activity->description;
            $this->type = $this->activity->type == 'G' ? false : true;
            if ($this->activity->type == 'E') {
                $this->inscriptions = $this->lessonService->event->inscriptions;
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
            $this->inscriptions = $this->lessonService->event->inscriptions;
        }
    }

    public function store(ActivityService $service)
    {
        $this->validate([
            'title' => 'required',
            'start_date' => 'date',
            'end_date' => 'date|after:start_date'
        ]);

        $request = [
            'id' => $this->activityId,
            'lesson_id' => $this->lessonId,
            'title' => $this->title,
            'description' => $this->description,
            'type' => ($this->type) ? 'E' : 'G',
            'userListActivity' => $this->userListActivity,
            'start_date' => ($this->start_date == '') ? $this->lessonService->start_date : $this->start_date,
            'end_date' => ($this->end_date == '') ? $this->lessonService->end_date : $this->end_date,
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
        $this->start_date = '';
        $this->end_date = '';
    }

    public function dellActivity(ActivityService $service)
    {
        $this->emit('refreshClassroom');
        $this->emit('refreshActivityList');
    }
}
