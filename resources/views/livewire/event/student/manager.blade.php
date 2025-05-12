<div class="card-white py-2 px-4">
    <x-search-form placeholder="Buscar aluno..." />

    <div class="overflow-auto" style="max-height: 400px;" id="students-container">
        @if(empty($inscriptions) || $inscriptions->isEmpty())
            @if(isset($showEmptyMessage) && $showEmptyMessage)
                <div class="mt-5">
                    <span class="text-red-500">Não há alunos inscritos com status Liberado, Aprovado ou Reprovado neste curso!</span>
                    @can('admin')
                    <div class="mt-3">
                        <a href="{{ route('eventInscription', ['id' => $event_id]) }}" class="btn-primary text-sm">
                            Inscrever alunos
                        </a>
                    </div>
                    @endcan
                </div>
            @else
                <div class="flex justify-center items-center py-6">
                    <div class="animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-blue-500"></div>
                    <span class="ml-2 text-gray-500">Carregando alunos...</span>
                </div>
                <script>
                    // Verificamos se o evento já foi emitido
                    document.addEventListener('DOMContentLoaded', function() {
                        // Evita emitir várias vezes
                        if (!window.studentsLoadTriggered) {
                            window.studentsLoadTriggered = true;
                            
                            // Primeiro tentar limpar o cache se for um reload
                            Livewire.emit('clearStudentsCache');
                            
                            // Em seguida, carregar os alunos
                            setTimeout(function() {
                                Livewire.emit('loadStudents');
                            }, 1000);
                            
                            // Definir um timeout para recarregar se demorar muito
                            setTimeout(function() {
                                if (document.querySelector('#students-container .animate-spin')) {
                                    Livewire.emit('refreshStudents');
                                }
                            }, 10000);
                        }
                    });
                </script>
            @endif
        @else
            @forelse ($inscriptions->take($perPage) as $key => $aluno)
                @can('monitorEvent', $event_id)
                <div>
                    <div
                        class="flex items-center mt-4 {{ (is_array($aluno->user->activityStatus) && count($aluno->user->activityStatus) > 0 || $aluno->user->absenceCount > 2) ? 'bg-infor p-2' : '' }}"
                    >
                        <img class="w-8 h-8 bg-black rounded-full mr-2" src="{{ asset($aluno->user->profile_photo_url) }}"
                            width="32" height="32" alt="{{ $aluno->user->name }}" onerror="this.src='{{ asset('images/avatar.svg') }}'" />
                        <livewire:event-student-status
                            :inscriptionId="$aluno->id"
                            :eventId="$event_id"
                            :student="$aluno->user"
                            :activityStatus="$aluno->user->activityStatus"
                            :absenceCount="$aluno->user->absenceCount"
                            :key="rand().$aluno->id"
                            lazy
                        />
                    </div>
                </div>
                @else
                    @can('aluno')
                    <div class="flex items-center mt-5 mb-4">
                        <img class="w-8 h-8 bg-black rounded-full mr-2" src="{{ asset($aluno->user->profile_photo_url) }}"
                            width="32" height="32" alt="{{ $aluno->user->name }}" onerror="this.src='{{ asset('images/avatar.svg') }}'" />
                        <a wire:click="sendMessage({{ $aluno->user->id }})"
                            class="font-bold text-md text-blue-500 hover:underline ml-2 cursor-pointer {{ $aluno->user->id == Auth::user()->id ? 'pointer-events-none' : '' }}">
                            <span class="truncate ml-2 text-sm font-medium group-hover:text-slate-800">{{ $aluno->user->name
                                }}</span>
                        </a>
                    </div>
                    @else
                    <div>
                        <div
                            class="flex items-center mt-4 {{ (is_array($aluno->user->activityStatus) && count($aluno->user->activityStatus) > 0 || $aluno->user->absenceCount > 2) ? 'bg-infor p-2' : '' }}"
                        >
                            <img class="w-8 h-8 bg-black rounded-full mr-2" src="{{ asset($aluno->user->profile_photo_url) }}"
                                width="32" height="32" alt="{{ $aluno->user->name }}" onerror="this.src='{{ asset('images/avatar.svg') }}'" />
                            <livewire:event-student-status
                                :inscriptionId="$aluno->id"
                                :eventId="$event_id"
                                :student="$aluno->user"
                                :activityStatus="$aluno->user->activityStatus"
                                :absenceCount="$aluno->user->absenceCount"
                                :key="rand().$aluno->id"
                                lazy
                            />
                        </div>
                    </div>
                    @endcan
                @endcan
            @empty
                <div class="mt-5">
                    <span class="text-red-500">Nenhuma inscrição realizada</span>
                </div>
            @endforelse

            @if($loadMore)
                <div class="mt-4 text-center" id="loading-indicator">
                    <div wire:loading.remove wire:target="loadMore" class="py-2">
                        <button wire:click="loadMore" class="btn-primary text-sm">
                            Carregar mais alunos
                        </button>
                    </div>
                    <div wire:loading wire:target="loadMore" class="py-2">
                        <button disabled class="btn-primary text-sm opacity-70 cursor-not-allowed flex items-center justify-center">
                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Carregando...
                        </button>
                    </div>
                </div>
            @elseif($reachedEnd && !$inscriptions->isEmpty())
                <div class="mt-4 text-center py-2">
                    <p class="text-gray-500 text-sm">Fim da lista</p>
                </div>
            @endif
        @endif
    </div>

    <script>
        // Flag global para controlar o carregamento
        let isLoadingStudents = false;
        
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('students-container');
            
            if (container) {
                container.addEventListener('scroll', function() {
                    // Se já estiver carregando, não dispara novamente
                    if (isLoadingStudents) return;
                    
                    const scrollPosition = container.scrollTop + container.clientHeight;
                    const scrollHeight = container.scrollHeight;
                    
                    // Quando chegar perto do final
                    if (scrollPosition >= scrollHeight - 100) {
                        isLoadingStudents = true;
                        
                        // Exibir manualmente o indicador de carregamento
                        const loadingIndicator = document.querySelector('[wire\\:loading][wire\\:target="loadMore"]');
                        const normalButton = document.querySelector('[wire\\:loading\\.remove][wire\\:target="loadMore"]');
                        
                        if (loadingIndicator && normalButton) {
                            loadingIndicator.style.display = 'block';
                            normalButton.style.display = 'none';
                        }
                        
                        // Emitir o evento para carregar mais alunos
                        Livewire.emit('loadMore');
                        
                        // Resetar a flag após um tempo
                        setTimeout(function() {
                            isLoadingStudents = false;
                            
                            // Retornar o estado original dos elementos (Livewire já deve ter feito isso)
                            if (loadingIndicator && normalButton) {
                                loadingIndicator.style.removeProperty('display');
                                normalButton.style.removeProperty('display');
                            }
                        }, 1500);
                    }
                });
            }
            
            // Escutar eventos do Livewire
            Livewire.hook('message.processed', (message, component) => {
                isLoadingStudents = false;
            });
        });
    </script>
</div>
