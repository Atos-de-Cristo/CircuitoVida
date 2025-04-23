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

    public function mount($eventId, $lessonId)
    {
        $this->eventId = $eventId;
        $this->lessonId = $lessonId;
        $this->users = [];
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
        $this->emit('refreshFrequency');
    }
}
