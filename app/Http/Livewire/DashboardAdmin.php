<?php

namespace App\Http\Livewire;

use App\Services\EventService;
use Livewire\Component;

class DashboardAdmin extends Component
{
    public function getEventServiceProperty()
    {
        return new EventService;
    }

    public array $labels =[];
    public array $data =[];
    public array $lessons =[];
    public function mount()
    {
        $events = $this->eventService->getLessonsWithCounts();

        foreach ($events as $event) {
            $eventName = $event->name;
            $inscriptionsCount = $event->inscriptions_count;
            $lessonsCount = $event->lessons_count;

            
        }
        $this->labels = $events->pluck('name')->toArray();
        $this->data = $events->pluck('inscriptions_count')->toArray();
        $this->data = $events->pluck('lessons_count')->toArray();
    
        
    }
    

    

    public function render()
    {
        return view('livewire.dashboard.admin');
    }
}
