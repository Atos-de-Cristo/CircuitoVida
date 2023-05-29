<?php

namespace App\Http\Livewire;

use App\Services\ActivityService;
use App\Services\EventService;
use App\Services\ModuleService;
use Livewire\Component;
use Livewire\WithFileUploads;

class EventActivity extends Component
{
    use WithFileUploads;

    protected $listeners = ['refreshComponent' => '$refresh'];

    public $eventId, $activityId;
    public $titleActivity, $type, $option;

    public function mount($eventId, $activityId)
    {
        $this->eventId = $eventId;
        $this->activityId = $activityId;
    }

    public function render(ActivityService $activityService)
    {
        $activities = $activityService->getAll([
            'event_id' => $this->eventId,
            'lesson_id' => $this->activityId
        ]);
        return view('livewire.event.activity.create', compact('activities'));
    }

    public function closeModalActivity()
    {
        $this->emit('closeModalActivity');
    }

    private function resetInputActivity()
    {
        $this->titleActivity = '';
        $this->type = '';
        $this->option = '';
    }

    public function storeActivity(ActivityService $service)
    {
        $this->validate([
            'titleActivity' => 'required',
            'type' => 'required',
            // 'option' => 'required'
        ]);

        $request = [
            'event_id' => $this->eventId,
            'lesson_id' => $this->activityId,
            'title' => $this->titleActivity,
            'type' => $this->type,
            'option' => $this->option
        ];

        $service->create($request);

        $this->resetInputActivity();
    }
}
