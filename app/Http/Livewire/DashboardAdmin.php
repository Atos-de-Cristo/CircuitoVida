<?php

namespace App\Http\Livewire;

use App\Services\EventService;
use App\Services\LessonService;
use App\Services\UserService;
use Livewire\Component;

class DashboardAdmin extends Component
{
    public array $labels =[];
    public array $data =[];
    public array $lessons =[];

    public function getEventServiceProperty()
    {
        return new EventService;
    }

    public function getUserServiceProperty()
    {
        return new UserService;
    }

    public function getLessonServiceProperty()
    {
        return new LessonService;
    }

    public function mount()
    {
        $events = $this->eventService->getLessonsWithCounts();

        $this->labels = $events->pluck('name')->toArray();
        $this->data = $events->pluck('inscriptions_count')->toArray();
        $this->data = $events->pluck('lessons_count')->toArray();
    }

    public function getMonitoresProperty()
    {
        $monitores = $this->userService->getMonitors();
        return $monitores->count();
    }

    public function getLessonsProperty()
    {
        $lessons = $this->lessonService->getAll();

        return $lessons->count();
    }

    public function getStudentsProperty()
    {
        $students = $this->userService->getStudents();
        return $students->count();
    }

    public function getEventsProperty()
    {
        $events = $this->eventService->getAll();
        return $events->count();
    }

    public function render()
    {
        return view('livewire.dashboard.admin');
    }
}
