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
            // Log do erro
            \Illuminate\Support\Facades\Log::error('Erro ao carregar alunos: ' . $e->getMessage());
        } finally {
            $this->loadingMore = false;
        }
    }

    public function refreshData()
    {
        $this->inscriptions = collect();
        $this->perPage = 10;
        $this->reachedEnd = false;
        $this->loadInscriptions();
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
                if ($item->user && !is_array($item->user->activityStatus)) {
                    $item->user->activityStatus = [];
                }
                
                // Define uma imagem de fallback se não existir
                if ($item->user && (!$item->user->profile_photo_url || str_contains($item->user->profile_photo_url, 'ui-avatars.com'))) {
                    $item->user->profile_photo_url = 'images/avatar.svg';
                }
                
                return $item;
            });
        }
        
        return view('livewire.event.student.manager', [
            'inscriptions' => $this->inscriptions,
            'loadMore' => $this->loadMore && !$this->reachedEnd,
            'loadingMore' => $this->loadingMore,
            'reachedEnd' => $this->reachedEnd
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
            $this->loadingMore = true;
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
            \Illuminate\Support\Facades\Log::error('Erro ao carregar mais alunos: ' . $e->getMessage());
        } finally {
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
        $this->refreshData();
    }
}
