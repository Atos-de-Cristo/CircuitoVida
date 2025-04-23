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
    public $loadingPresence = [];
    public $loadingJustification = false;

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
        $loadingKey = "{$userId}_{$lessonId}";
        $this->loadingPresence[$loadingKey] = true;
        
        $frequencyService = new FrequencyService();
        
        // Verificar se o aluno já tem frequência nesta aula
        $existingFrequencies = $frequencyService->getAll([
            'user_id' => $userId,
            'lesson_id' => $lessonId,
            'event_id' => $this->eventId,
        ]);
        
        if ($existingFrequencies->count() > 0) {
            // Se já tem frequência, atualiza o is_present
            foreach ($existingFrequencies as $frequency) {
                $frequencyService->update($frequency->id, [
                    'is_present' => !$frequency->is_present
                ]);
            }
        } else {
            // Se não tem frequência, adiciona com is_present = true
            $frequencyService->create([
                'user_id' => $userId,
                'lesson_id' => $lessonId,
                'event_id' => $this->eventId,
                'inscription_id' => $inscriptionId,
                'is_present' => true
            ]);
        }
        
        $this->loadingPresence[$loadingKey] = false;
        $this->emit('refreshFrequency');
    }
    
    public function changePerPage($value)
    {
        $this->perPage = $value;
        $this->resetPage();
    }

    public function openJustificationModal($userId, $lessonId, $inscriptionId)
    {
        $this->loadingJustification = true;
        
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
        
        $this->loadingJustification = false;
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
                'is_justified' => !empty($this->currentJustification),
                'is_present' => empty($this->currentJustification) ? $existingFrequency->is_present : false // Se tem justificativa, marca como falta (is_present = false)
            ]);
        } else {
            // Criar nova frequência com justificativa e marcar como falta
            $frequencyService->create([
                'user_id' => $this->selectedUserId,
                'lesson_id' => $this->selectedLessonId,
                'event_id' => $this->eventId,
                'inscription_id' => $this->selectedInscriptionId,
                'justification' => $this->currentJustification,
                'is_justified' => !empty($this->currentJustification),
                'is_present' => false // Se está criando com justificativa, marca como falta (is_present = false)
            ]);
        }
        
        $this->closeJustificationModal();
        $this->emit('refreshFrequency');
    }
} 