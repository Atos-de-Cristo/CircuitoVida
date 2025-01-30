<?php

namespace App\Http\Livewire;

use App\Services\LessonService;
use Illuminate\Http\Request;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Classroom extends Component
{
    public $lessonId, $eventId;
    public $isOpenFrequency = false;

    protected $listeners = [
        'refreshClassroom' => '$refresh'
    ];

    public function getLessonServiceProperty()
    {
        return new LessonService;
    }

    public function mount(Request $request)
    {
        $this->eventId = $request->eventId;
        $this->lessonId = $request->id;

        if (Auth::user()->profile === null && Auth::user()->isAdmin === false) {
            return redirect()->route('profile.show')->with('message', [
                'text' => 'Preecha seu Perfil completo' ,
                'type' => 'error',
            ]);
        }
    }

    public function render()
    {
        $lessonData = $this->lessonService->find($this->lessonId);
        return view('livewire.event.classroom.index', compact('lessonData'));
    }
}
