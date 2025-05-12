<?php

namespace App\Http\Livewire;
use App\Services\InscriptionService;
use Livewire\Component;
use Livewire\WithPagination;

class EventAlunos extends Component
{
    use WithPagination;
    
    public $event_id;
    public $search = '';
    public $perPage = 10;
    public $inscriptions = [];
    public $loadMore = false;
    public $loadingMore = false;
    public $hasTriggeredInitialLoad = false;
    public $reachedEnd = false;

    protected $queryString = ['search'];

    protected $listeners = [
        'refreshStudents' => 'refreshData',
        'loadStudents' => 'loadInscriptions',
        'clearStudentsCache' => 'clearCache',
        'loadMore' => 'loadMore'
    ];

    public function mount($id)
    {
        $this->event_id = $id;
        $this->loadInscriptions(); // Carregar dados imediatamente na montagem
    }

    public function loadInscriptions()
    {
        if ($this->loadingMore) {
            return; // Evitar carregamentos simultâneos
        }

        try {
            $this->loadingMore = true;
            $service = app(InscriptionService::class);
            
            $this->inscriptions = $service->getAllStudent($this->search, $this->event_id);
            
            // Verificar se há mais alunos para mostrar além do valor atual de perPage
            $this->loadMore = $this->inscriptions->count() > $this->perPage;
            $this->reachedEnd = !$this->loadMore;
            
            $this->hasTriggeredInitialLoad = true;
        } catch (\Exception $e) {
            // Silenciar erros para evitar quebrar a interface
        } finally {
            $this->loadingMore = false;
        }
    }

    public function refreshData()
    {
        try {
            // Limpar cache primeiro
            $this->clearCache();
            
            // Resetar estado
            $this->inscriptions = collect();
            $this->perPage = 10;
            $this->reachedEnd = false;
            $this->hasTriggeredInitialLoad = false;
            
            // Carregar novamente
            $this->loadInscriptions();
        } catch (\Exception $e) {
            // Silenciar erros
        }
    }

    public function updatedSearch()
    {
        $this->resetPage();
        $this->perPage = 10;
        $this->reachedEnd = false;
        $this->loadInscriptions();
    }

    public function render()
    {
        // Garantir que activityStatus seja sempre um array (corrigindo o erro de contagem)
        if (!empty($this->inscriptions)) {
            $this->inscriptions = $this->inscriptions->map(function ($item) {
                // Verificar se é array ou objeto
                if (is_array($item)) {
                    // Converter para objeto se for array
                    $item = (object) $item;
                    
                    // Garantir que user é um objeto
                    if (isset($item->user) && is_array($item->user)) {
                        $item->user = (object) $item->user;
                    }
                }
                
                // Verificar se o user existe antes de continuar
                if (!isset($item->user)) {
                    return $item;
                }
                
                // Garantir que activityStatus seja um array
                if (!isset($item->user->activityStatus) || !is_array($item->user->activityStatus)) {
                    $item->user->activityStatus = [];
                }
                
                // Define uma imagem de fallback se não existir
                if (!isset($item->user->profile_photo_url) || 
                    empty($item->user->profile_photo_url) || 
                    (is_string($item->user->profile_photo_url) && str_contains($item->user->profile_photo_url, 'ui-avatars.com'))) {
                    $item->user->profile_photo_url = 'images/avatar.svg';
                }
                
                return $item;
            });
        }
        
        // Verificar se continua vazio depois de várias tentativas
        $showEmptyMessage = $this->hasTriggeredInitialLoad && $this->inscriptions->isEmpty();
        
        return view('livewire.event.student.manager', [
            'inscriptions' => $this->inscriptions,
            'loadMore' => $this->loadMore && !$this->reachedEnd,
            'loadingMore' => $this->loadingMore,
            'reachedEnd' => $this->reachedEnd,
            'showEmptyMessage' => $showEmptyMessage,
            'event_id' => $this->event_id
        ]);
    }

    /**
     * Carregar mais alunos quando o usuário rolar para baixo
     */
    public function loadMore()
    {
        if ($this->loadingMore || $this->reachedEnd) {
            return;
        }
        
        try {
            // Definir loadingMore como true e notificar a UI
            $this->loadingMore = true;
            
            // Adicionar um pequeno atraso para garantir que o estado de carregamento seja visível
            usleep(500000); // 500ms de atraso
            
            // Aumentar o número de itens visíveis em 10
            $oldPerPage = $this->perPage;
            $this->perPage += 10;
            
            // Verificar se ainda há mais itens para exibir
            $this->loadMore = $this->inscriptions->count() > $this->perPage;
            
            // Se o número de itens for menor ou igual ao novo perPage, então chegamos ao fim
            if ($this->inscriptions->count() <= $this->perPage) {
                $this->reachedEnd = true;
                $this->loadMore = false;
            }
        } catch (\Exception $e) {
            // Silenciar erros
        } finally {
            // Garantir que loadingMore seja definido como false no final
            $this->loadingMore = false;
        }
    }

    public function sendMessage($idSend)
    {
        $this->emit('openSendMessage', $idSend);
    }

    public function clearCache()
    {
        $cacheKey = "students_event_{$this->event_id}_search_" . md5($this->search);
        \Illuminate\Support\Facades\Cache::forget($cacheKey);
    }
}
