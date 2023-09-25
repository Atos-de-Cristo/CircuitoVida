<?php

namespace App\Http\Livewire;

use App\Services\EventService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class CopyingCourseData extends Component
{
    public $eventId, $course;
    public $search = '';
    public $isOpenCopyData = false;

    public function boot(Request $request)
    {
        $this->eventId = $request->eventId;
    }

    public function getServiceProperty()
    {
        return new EventService;
    }

    public function getCoursesProperty()
    {
        return $this->service->getAll(['name' => $this->search]);
    }

    public function render()
    {
        return view('livewire.event.copying-course-data');
    }

    public function copyCourse(EventService $eventService)
    {
        if (!$this->course) {
            Session::flash('message', [
                'text' => 'Selecione um curso para copiar',
                'type' => 'error',
            ]);
            return false;
        }

        $request = [
            'event_id' => $this->eventId,
            'course' => $this->course
        ];

        $copyData = $eventService->copyCourseData($request);

        if (!$copyData) {
            Session::flash('message', [
                'text' => 'Erro ao copiar, contate o administrador!',
                'type' => 'error',
            ]);
            return false;
        }

        $this->emit('refreshManage');
        $this->isOpenCopyData = false;
    }
}
