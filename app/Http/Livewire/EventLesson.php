<?php

namespace App\Http\Livewire;

use App\Services\LessonService;
use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

class EventLesson extends Component
{
    public $eventId, $moduleId, $lessonId;
    public $title, $description, $video, $start_date, $end_date;
    public $modalActivity;
    public $isOpenLesson = false;

    public function boot(Request $request)
    {
        $this->eventId = $request->eventId;
        $this->moduleId = $request->moduleId;
        $this->lessonId = $request->lessonId;
    }

    public function mount()
    {
        if ($this->lessonId) {
            if (Auth::user()->profile === null && Auth::user()->isAdmin === false) {
                return redirect()->route('profile.show')->with('message', [
                    'text' => 'Preecha seu Perfil completo' ,
                    'type' => 'error',
                ]);
            }
            $this->editLesson();
        }
    }

    public function render()
    {
        return view('livewire.event.lesson');
    }

    public function editLesson()
    {
        $service = new LessonService;
        $lessonData = $service->find($this->lessonId);

        $this->title = $lessonData->title;
        $this->description = $lessonData->description;
        $this->video = $lessonData->video;
        $lessonData->start_date ? $this->start_date = date('Y-m-d H:i:s', strtotime($lessonData->start_date)) : '';
        $lessonData->end_date ? $this->end_date = date('Y-m-d H:i:s', strtotime($lessonData->end_date)) : '';
    }

    public function store(LessonService $service)
    {
        try {
            $this->validate([
                'title' => 'required',
                'start_date' => 'date',
                'end_date' => 'date|after:start_date',
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

            $this->isOpenLesson = false;
            $this->emit('refreshManage');
        } catch (ValidationException $e) {
            $errors = $e->validator->errors();

            $this->resetErrorBag();

            foreach ($errors->messages() as $field => $fieldErrors) {
                foreach ($fieldErrors as $error) {
                    $this->addError($field, $error);
                }
            }
        }
    }

    public function dellLesson(LessonService $service)
    {
        $service->delete($this->lessonId);
        $this->emit('refreshManage');
    }
}
