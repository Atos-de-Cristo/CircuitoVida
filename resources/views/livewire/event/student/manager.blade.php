<div class="card-white py-2 px-4">
    <x-search-form placeholder="Buscar aluno..." />

    <div class="overflow-auto" style="max-height: 400px;" id="students-container">
        @if(empty($inscriptions) || $inscriptions->isEmpty())
            <div class="flex justify-center items-center py-6">
                <div class="animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-blue-500"></div>
                <span class="ml-2 text-gray-500">Carregando alunos...</span>
            </div>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Livewire.emit('loadStudents');
                });
            </script>
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
                        <div class="animate-spin rounded-full h-5 w-5 border-t-2 border-b-2 border-blue-500 mx-auto mb-1"></div>
                        <div class="text-gray-500 text-sm">Carregando mais alunos...</div>
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
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('students-container');
            
            if (container) {
                container.addEventListener('scroll', function() {
                    const scrollPosition = container.scrollTop + container.clientHeight;
                    const scrollHeight = container.scrollHeight;
                    
                    if (scrollPosition >= scrollHeight - 50) {
                        Livewire.emit('loadMore');
                    }
                });
            }
        });
    </script>
</div>
