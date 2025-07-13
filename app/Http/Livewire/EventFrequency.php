<?php

namespace App\Http\Livewire;

use App\Services\FrequencyService;
use App\Services\InscriptionService;
use Livewire\Component;

class EventFrequency extends Component
{
    public $eventId, $lessonId;
    public array $users;
    public $isOpenFrequency = false;
    public $loadingPresence = [];
    public $showJustificationFor = null; // ID do usuário que está editando justificativa
    public $justificationText = '';
    public $selectedUserId;
    public $selectedInscriptionId;
    public $selectedLessonId; // Armazena o lesson_id selecionado para justificativa
    public $loadingJustification = false;
    public $justificationActive = false; // Flag para prevenir fechamento do modal

    protected $listeners = [
        'refreshFrequency' => 'handleRefreshFrequency',
        'modalClosing' => 'handleModalClosing'
    ];

    public function mount($eventId, $lessonId)
    {
        $this->eventId = $eventId;
        $this->lessonId = $lessonId;
        $this->users = [];
    }

    public function handleRefreshFrequency()
    {
        // Só executar refresh se não estiver editando justificativa
        if (!$this->justificationActive) {
            $this->render(new InscriptionService());
        }
    }

    public function closeFrequencyModal()
    {
        // Só fechar se não estiver editando justificativa
        if (!$this->justificationActive) {
            $this->isOpenFrequency = false;
        }
    }

    public function refreshFrequencyData()
    {
        // Método para atualizar apenas os dados sem afetar o modal
        // Não faz nada especial, apenas força o Livewire a re-renderizar
    }

    public function updatedIsOpenFrequency($value)
    {
        // Prevenir fechamento do modal durante edição de justificativa
        if (!$value && $this->justificationActive) {
            $this->isOpenFrequency = true;
        }
    }

    public function handleModalClosing()
    {
        // Prevenir fechamento do modal se justificativa estiver ativa
        if ($this->justificationActive) {
            $this->isOpenFrequency = true;
        }
    }

    public function render(InscriptionService $inscriptionService)
    {
        $inscriptions = $inscriptionService->getFrequency($this->eventId, $this->lessonId);
        return view('livewire.event.frequency.create', compact('inscriptions'));
    }

    public function storeFrequency(FrequencyService $frequencyService)
    {
        $request = [];
        foreach ($this->users as $key => $data) {
            $dataConvert = json_decode($data);
            $request[$key]['user_id'] = $dataConvert->user_id;
            $request[$key]['inscription_id'] = $dataConvert->id;
            $request[$key]['event_id'] = $this->eventId;
            $request[$key]['lesson_id'] = $this->lessonId;
        }

        $frequencyService->create($request);

        $this->isOpenFrequency = false;
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
        
        // Pequeno atraso para garantir que o loading seja visível
        usleep(200000); // 300ms
        
        $this->loadingPresence[$loadingKey] = false;
        // Removido emit('refreshFrequency') para evitar fechamento do modal
    }

    public function openJustificationModal($userId, $lessonId, $inscriptionId, $userName)
    {
        $this->justificationActive = true;
        $this->selectedUserId = $userId;
        $this->selectedInscriptionId = $inscriptionId;
        $this->selectedLessonId = $lessonId; // Armazenar o lesson_id correto
        
        // Garantir que o modal permaneça aberto
        $this->isOpenFrequency = true;
        
        // Buscar justificativa existente, se houver
        $frequencyService = new FrequencyService();
        $existingFrequency = $frequencyService->getAll([
            'user_id' => $userId,
            'lesson_id' => $lessonId, // Usar o parâmetro correto
            'event_id' => $this->eventId,
        ])->first();
        
        $this->justificationText = $existingFrequency ? $existingFrequency->justification : '';
        $this->showJustificationFor = $userId;
    }
    
    public function closeJustificationModal()
    {
        $this->showJustificationFor = null;
        $this->justificationText = '';
        $this->selectedUserId = null;
        $this->selectedInscriptionId = null;
        $this->selectedLessonId = null;
        $this->justificationActive = false;
    }
    
    public function saveJustification()
    {
        $frequencyService = new FrequencyService();
        
        // Verificar se já existe frequência para esse aluno/aula
        $existingFrequency = $frequencyService->getAll([
            'user_id' => $this->selectedUserId,
            'lesson_id' => $this->selectedLessonId, // Usar o lesson_id correto
            'event_id' => $this->eventId,
        ])->first();
        
        if ($existingFrequency) {
            // Atualizar a justificativa existente
            $frequencyService->update($existingFrequency->id, [
                'justification' => $this->justificationText,
                'is_justified' => !empty($this->justificationText),
                'is_present' => empty($this->justificationText) ? $existingFrequency->is_present : false
            ]);
        } else {
            // Criar nova frequência com justificativa e marcar como falta
            $frequencyService->create([
                'user_id' => $this->selectedUserId,
                'lesson_id' => $this->selectedLessonId, // Usar o lesson_id correto
                'event_id' => $this->eventId,
                'inscription_id' => $this->selectedInscriptionId,
                'justification' => $this->justificationText,
                'is_justified' => !empty($this->justificationText),
                'is_present' => false
            ]);
        }
        
        // Fechar o campo de justificativa
        $this->closeJustificationModal();
        
        // Atualizar apenas a view após um pequeno delay, sem fechar o modal
        $this->dispatchBrowserEvent('justification-saved');
    }
}
