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
        'refreshComponent' => '$refresh',
        'closeModalFrequency' => 'closeModalFrequency'
    ];

    public function boot(Request $request)
    {
        $this->eventId = $request->eventId;
        $this->lessonId = $request->id;
    }

    public function render(LessonService $lessonService)
    {
        $lessonData = $lessonService->find($this->lessonId);
        return view('livewire.event.classroom', compact('lessonData'));
    }

    public function openModalFrequency()
    {
        $this->isOpenFrequency = true;
    }

    public function closeModalFrequency()
    {
        $this->isOpenFrequency = false;
    }
}
