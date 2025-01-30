<?php

namespace App\Http\Livewire;

use App\Services\ActivityService;
use Illuminate\Http\Request;
use Livewire\Component;
use Livewire\WithFileUploads;

class EventActivityList extends Component
{
    use WithFileUploads;

    public $lessonId;
    public $isOpenQuestions = false;
    public $atvId;
    public $eventId;
    protected $listeners = [
        'refreshActivityList' => '$refresh',
        'closeModalQuestions' => 'closeModalQuestions'
    ];

    public function boot(Request $request)
    {
        $this->lessonId = $request->id;
    }

    public function render(ActivityService $activityService)
    {
        $activities = $activityService->getAll([
            'lesson_id' => $this->lessonId
        ]);
        $eventId = $this->eventId;
        return view('livewire.event.activity.list', compact('activities', 'eventId'));
    }

    public function openModalQuestions($atvId)
    {
        $this->atvId = $atvId;
        $this->isOpenQuestions = true;
    }

    public function closeModalQuestions()
    {
        $this->atvId = null;
        $this->isOpenQuestions = false;
    }
}
