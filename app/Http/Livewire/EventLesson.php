<?php

namespace App\Http\Livewire;

use App\Services\LessonService;
use Livewire\Component;
use Illuminate\Http\Request;

class EventLesson extends Component
{
    public $eventId, $moduleId, $lessonId;
    public $title, $description, $video, $start_date, $end_date;
    public $modalActivity;

    public function boot(Request $request)
    {
        $this->eventId = $request->eventId;
        $this->moduleId = $request->moduleId;
        $this->lessonId = $request->lessonId;
    }

    public function booted()
    {
        if ($this->lessonId) {
            $this->editLesson();
        }
    }

    public function render()
    {
        return view('livewire.event.lesson');
    }

    public function closeModal()
    {
        $this->emit('closeModalLesson');
    }

    public function editLesson()
    {
        $service = new LessonService;
        $lessonData = $service->find($this->lessonId);

        $this->title = $lessonData->title;
        $this->description = $lessonData->description;
        $this->video = $lessonData->video;
        $this->start_date = date('Y-m-d H:i:s', strtotime($lessonData->start_date));
        $this->end_date = date('Y-m-d H:i:s', strtotime($lessonData->end_date));
    }

    public function store(LessonService $service)
    {
        $this->validate([
            'title' => 'required'
        ]);

        $request = [
            'event_id' => $this->eventId,
            'module_id' => $this->moduleId,
            'title' => $this->title,
            'description' => $this->description,
            'video' => $this->video,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
        ];

        if ($this->lessonId) {
            $request['id'] = $this->lessonId;
        }

        $service->store($request);

        session()->flash('message', 'Aula cadastrado com sucesso.');

        $this->closeModal();
    }
}
