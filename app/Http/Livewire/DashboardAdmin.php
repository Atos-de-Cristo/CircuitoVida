<?php

namespace App\Http\Livewire;

use App\Enums\InscriptionStatus;
use App\Services\EventService;
use App\Services\InscriptionService;
use App\Services\LessonService;
use App\Services\UserService;
use Livewire\Component;

class DashboardAdmin extends Component
{
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

    public function getInscriptionServiceProperty()
    {
        return new InscriptionService;
    }

    public function getChartInscriptionsProperty()
    {
        $events = $this->eventService->getLessonsWithCounts();
        $labels = $events->where('status', '!=', 'F')->pluck('name')->toArray();
        $values = $events->where('status', '!=', 'F')->pluck('inscriptions_count')->toArray();

        return [
            "labels" => $labels,
            "values" => $values
        ];
    }

    public function getChartUserActiveProperty()
    {
        $studentActive = $this->userService->countStudentsActive();
        $studentTotal = $this->userService->countStudents();

        return [
            "labels" => ['Alunos Ativos', 'Alunos Inativos'],
            "values" => [$studentActive, $studentTotal]
        ];
    }

    public function getChartInscriptionStatusProperty()
    {
        $statusCounts = $this->inscriptionService->sumInscriptions();

        $labels = [];
        $values = [];

        foreach ($statusCounts as $statusCount) {
            $labels[] = InscriptionStatus::fromValue($statusCount['status']);
            $values[] = $statusCount['total'];
        }

        return [
            "labels" => $labels,
            "values" => $values
        ];
    }

    public function getMonitoresProperty()
    {
        $monitores = $this->userService->getMonitors();
        return $monitores->count();
    }

    public function getLessonsProperty()
    {
        return $this->lessonService->countTotalLessons();
    }

    public function getStudentsProperty()
    {
        return $this->userService->countStudentsActive();
    }

    public function getEventsProperty()
    {
        return $this->eventService->countActivityCourse();
    }

    public function render()
    {
        return view('livewire.dashboard.admin');
    }
}
