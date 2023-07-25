<?php

namespace App\Http\Livewire;

use App\Services\LessonService;
use Illuminate\Http\Request;
use Livewire\Component;

class Classroom extends Component
{
    public $lessonId, $eventId;
    public $isOpenFrequency = false;

    protected $listeners = [
        'refreshClassroom' => '$refresh',
        'closeModalFrequency' => 'closeModalFrequency',
        'closeModalAttachment' => 'closeModalAttachment'
    ];

    public function getLessonServiceProperty()
    {
        return new LessonService;
    }

    public function mount(Request $request)
    {
        $this->eventId = $request->eventId;
        $this->lessonId = $request->id;
    }

    public function render()
    {
        $lessonData = $this->lessonService->find($this->lessonId);
        return view('livewire.event.classroom', compact('lessonData'));
    }


}
