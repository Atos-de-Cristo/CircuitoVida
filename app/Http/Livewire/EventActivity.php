<?php

namespace App\Http\Livewire;

use App\Services\ActivityService;
use Livewire\Component;
use Livewire\WithFileUploads;

class EventActivity extends Component
{
    use WithFileUploads;

    public $eventId, $lessonId;
    public $title, $description;
    public $isOpenQuestions;

    public function mount($eventId, $lessonId)
    {
        $this->eventId = $eventId;
        $this->lessonId = $lessonId;
    }

    public function render(ActivityService $activityService)
    {
        $activities = $activityService->getAll([
            'event_id' => $this->eventId,
            'lesson_id' => $this->lessonId
        ]);
        return view('livewire.event.activity.create', compact('activities'));
    }

    public function closeModalActivity()
    {
        $this->emit('closeModalActivity');
    }

    private function resetInputActivity()
    {
        $this->title = '';
        $this->description = '';
    }

    public function storeActivity(ActivityService $service)
    {
        $this->validate([ 'title' => 'required' ]);

        $request = [
            'event_id' => $this->eventId,
            'lesson_id' => $this->lessonId,
            'title' => $this->title,
            'description' => $this->description
        ];

        $service->create($request);

        $this->resetInputActivity();
    }

    public function openModalQuestions()
    {
        $this->isOpenQuestions = true;
    }

    public function closeModalQuestions()
    {
        $this->isOpenQuestions = false;
    }
}
