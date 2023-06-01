<?php

namespace App\Http\Livewire;

use App\Services\LessonService;
use Illuminate\Http\Request;
use Livewire\Component;

class Classroom extends Component
{
    public $lessonId;

    public function boot(Request $request)
    {
        $this->lessonId = $request->id;
    }

    public function render(LessonService $lessonService)
    {
        $lessonData = $lessonService->find($this->lessonId);
        return view('livewire.event.classroom', compact('lessonData'));
    }
}
