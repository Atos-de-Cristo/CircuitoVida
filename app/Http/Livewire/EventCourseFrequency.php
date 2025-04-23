<?php

namespace App\Http\Livewire;

use App\Services\EventService;
use App\Services\FrequencyService;
use App\Services\InscriptionService;
use App\Services\LessonService;
use Illuminate\Http\Request;
use Livewire\Component;
use Livewire\WithPagination;

class EventCourseFrequency extends Component
{
    use WithPagination;
    
    public $eventId;
    public $search = '';
    public $frequencies = [];
    public $perPage = 10;
    public $showJustificationModal = false;
    public $currentJustification = '';
    public $selectedUserId;
    public $selectedLessonId;
    public $selectedInscriptionId;

    protected $queryString = ['search', 'perPage'];
    
    protected $listeners = [
        'refreshFrequency' => '$refresh'
    ];

    public function mount($eventId = null)
    {
        $this->eventId = $eventId;
    }

    public function getEventServiceProperty()
    {
        return new EventService;
    }

    public function getInscriptionServiceProperty()
    {
        return new InscriptionService;
    }

    public function getLessonServiceProperty()
    {
        return new LessonService;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $event = $this->eventService->find($this->eventId);
        $inscriptionsQuery = $this->inscriptionService->getFrequency($this->eventId);
        
        // Filtrar por busca
        $filteredInscriptions = $inscriptionsQuery->filter(function($insc) { 
            return empty($this->search) || 
                   str_contains(strtolower($insc->user->name), strtolower($this->search));
        });
        
        // Aplicar paginação manual 
        $currentPage = $this->page;
        $perPage = $this->perPage;
        $currentItems = $filteredInscriptions->slice(($currentPage - 1) * $perPage, $perPage);
        $paginatedInscriptions = new \Illuminate\Pagination\LengthAwarePaginator(
            $currentItems,
            $filteredInscriptions->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );
        
        // Buscar as aulas com seus módulos
        $lessons = $this->lessonService->getAll(['event_id' => $this->eventId])->load('module');
        
        return view('livewire.event.frequency.course', compact('event', 'paginatedInscriptions', 'lessons'));
    }

    public function toggleFrequency($userId, $lessonId, $inscriptionId)
    {
        $frequencyService = new FrequencyService();
        
        // Verificar se o aluno já tem frequência nesta aula
        $existingFrequencies = $frequencyService->getAll([
            'user_id' => $userId,
            'lesson_id' => $lessonId,
            'event_id' => $this->eventId,
        ]);
        
        if ($existingFrequencies->count() > 0) {
            // Se já tem frequência, remove
            foreach ($existingFrequencies as $frequency) {
                $frequencyService->delete($frequency->id);
            }
        } else {
            // Se não tem frequência, adiciona
            $frequencyService->create([
                'user_id' => $userId,
                'lesson_id' => $lessonId,
                'event_id' => $this->eventId,
                'inscription_id' => $inscriptionId
            ]);
        }
        
        $this->emit('refreshFrequency');
    }
    
    public function changePerPage($value)
    {
        $this->perPage = $value;
        $this->resetPage();
    }

    public function openJustificationModal($userId, $lessonId, $inscriptionId)
    {
        $this->selectedUserId = $userId;
        $this->selectedLessonId = $lessonId;
        $this->selectedInscriptionId = $inscriptionId;
        
        // Buscar justificativa existente, se houver
        $frequencyService = new FrequencyService();
        $existingFrequency = $frequencyService->getAll([
            'user_id' => $userId,
            'lesson_id' => $lessonId,
            'event_id' => $this->eventId,
        ])->first();
        
        $this->currentJustification = $existingFrequency ? $existingFrequency->justification : '';
        $this->showJustificationModal = true;
    }
    
    public function closeJustificationModal()
    {
        $this->showJustificationModal = false;
        $this->currentJustification = '';
        $this->selectedUserId = null;
        $this->selectedLessonId = null;
        $this->selectedInscriptionId = null;
    }
    
    public function saveJustification()
    {
        $frequencyService = new FrequencyService();
        
        // Verificar se já existe frequência para esse aluno/aula
        $existingFrequency = $frequencyService->getAll([
            'user_id' => $this->selectedUserId,
            'lesson_id' => $this->selectedLessonId,
            'event_id' => $this->eventId,
        ])->first();
        
        if ($existingFrequency) {
            // Atualizar a justificativa existente
            $frequencyService->update($existingFrequency->id, [
                'justification' => $this->currentJustification,
                'is_justified' => !empty($this->currentJustification)
            ]);
        } else {
            // Criar nova frequência com justificativa
            $frequencyService->create([
                'user_id' => $this->selectedUserId,
                'lesson_id' => $this->selectedLessonId,
                'event_id' => $this->eventId,
                'inscription_id' => $this->selectedInscriptionId,
                'justification' => $this->currentJustification,
                'is_justified' => !empty($this->currentJustification)
            ]);
        }
        
        $this->closeJustificationModal();
        $this->emit('refreshFrequency');
    }
} 