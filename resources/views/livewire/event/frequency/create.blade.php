

{{-- <div>
    <div class="mt-2 sm:mt-0 flex space-x-2">
        <button wire:click.prevent="$set('isOpenFrequency', true)" class="btn-primary">
            <x-icon-check class="w-4 h-4" />
            <span class="ml-2">Fequência</span>
        </button>
    </div>
    @if ($isOpenFrequency)
    <x-dialog-modal id="myModal" wire:model="isOpenFrequency" maxWidth="lg" closeModal="closeFrequencyModal">
        <x-slot name="title">
         Frequência Aula
        </x-slot>

        <x-slot name="content">
            <form>
                <div class="max-h-96 bg-gray-50">
                    <div class="flex flex-col w-full dark:bg-slate-800">
                        @foreach($inscriptions as $item)
                        @php
                            $frequency = $item->frequencies->where('user_id', $item->user->id)->where('lesson_id', $lessonId)->first();
                            $isPresent = $frequency ? $frequency->is_present : false;
                            $isJustified = $frequency && $frequency->is_justified;
                            $loadingKey = $item->user->id . '_' . $lessonId;
                            $now = now();
                            $lesson = \App\Models\Lesson::find($lessonId);
                            $lessonStarted = $lesson && $lesson->start_date && \Carbon\Carbon::parse($lesson->start_date)->startOfDay()->lte($now->startOfDay());
                        @endphp
                        <div class="flex flex-col w-full">
                            <div class="flex items-center justify-between border-b px-2 py-2">
                                @isset($item->user->profile_photo_url)
                                    <img class="w-8 h-8 bg-black rounded-full mr-2"
                                        src="{{ asset($item->user->profile_photo_url) }}" width="32" height="32"
                                        alt="Foto Perfil"
                                    />
                                @endisset
                                @isset($item->user->name)
                                    <div class="flex-1">{{ $item->user->name }}</div>
                                @endisset
                                @isset($item->user->id)
                                    <div class="flex items-center space-x-2">
                                        <button 
                                            class="text-yellow-500 hover:text-yellow-700 dark:text-yellow-400 dark:hover:text-yellow-300"
                                            wire:click="openJustificationModal('{{ $item->user->id }}', '{{ $lessonId }}', '{{ $item->id }}', '{{ $item->user->name }}')"
                                            wire:loading.attr="disabled"
                                            title="{{ $isJustified ? 'Falta justificada' : 'Justificar falta' }}"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 {{ $isJustified ? 'text-yellow-500 fill-yellow-500' : 'text-gray-400' }}" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                        <div wire:loading wire:target="toggleFrequency('{{ $item->user->id }}', '{{ $lessonId }}', '{{ $item->id }}')">
                                            <svg class="animate-spin h-5 w-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                        </div>
                                        <input
                                            wire:loading.attr="disabled"
                                            wire:loading.remove wire:target="toggleFrequency('{{$item->user->id }}', '{{ $lessonId }}', '{{ $item->id }}')"
                                            id="freq-{{ $item->user->id }}"
                                            type="checkbox"
                                            value="{{ $item }}"
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 {{ !$lessonStarted ? 'opacity-50 cursor-not-allowed' : '' }}"
                                            wire:click="toggleFrequency('{{ $item->user->id }}', '{{ $lessonId }}', '{{ $item->id }}')"
                                            @if($isPresent) checked @endif
                                            {{ !$lessonStarted ? 'disabled' : '' }}
                                            title="{{ !$lessonStarted ? 'Não é possível marcar presença em aulas que ainda não iniciaram' : 'Marcar presença' }}"
                                        >
                                    </div>
                                @endisset
                            </div>
                            
                            <!-- Campo de justificativa inline -->
                            @if($showJustificationFor == $item->user->id)
                                <div class="bg-gray-50 dark:bg-slate-700 p-3 border-l-4 border-yellow-400 mx-2 mb-2 rounded-r-md">
                                    <div class="mb-2">
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                            Justificativa de falta para {{ $item->user->name }}
                                        </label>
                                    </div>
                                    <div class="mb-3">
                                        <textarea
                                            wire:model="justificationText"
                                            class="w-full h-20 p-2 border border-gray-300 dark:border-slate-600 rounded-md text-sm dark:bg-slate-800 dark:text-white resize-none"
                                            placeholder="Insira a justificativa da falta aqui..."
                                        ></textarea>
                                    </div>
                                    <div class="flex space-x-2">
                                        <button 
                                            wire:click="saveJustification" 
                                            class="px-3 py-1 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        >
                                            Salvar
                                        </button>
                                        <button 
                                            wire:click="closeJustificationModal" 
                                            class="px-3 py-1 bg-gray-500 text-white text-sm rounded hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500"
                                        >
                                            Cancelar
                                        </button>
                                    </div>
                                </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
            </form>

        </x-slot>

        <x-slot name="footer">
            <span class="flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                <button 
                    wire:click="closeFrequencyModal" 
                    type="button" 
                    class="btn-default"
                    @if($justificationActive) disabled title="Termine de editar a justificativa antes de fechar" @endif
                >
                    Fechar
                </button>
            </span>
        </x-slot>
    </x-dialog-modal>
    @endif

 
</div> --}}

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Event listener para atualizar a view quando justificativa for salva
    window.addEventListener('justification-saved', event => {
        // Pequeno delay para garantir que os dados foram salvos
        setTimeout(function() {
            // Usar método específico para atualizar apenas os dados
            @this.call('refreshFrequencyData');
        }, 300);
    });

    // Prevenir fechamento do modal durante edição de justificativa
    let modalObserver = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.type === 'attributes' && mutation.attributeName === 'style') {
                // Se modal está tentando fechar e justificativa está ativa, reabrir
                if (@this.justificationActive && !@this.isOpenFrequency) {
                    @this.set('isOpenFrequency', true);
                }
            }
        });
    });

    // Observar mudanças no modal
    const modal = document.getElementById('myModal');
    if (modal) {
        modalObserver.observe(modal, {
            attributes: true,
            attributeFilter: ['style', 'class']
        });
    }

    // Força o modal a permanecer aberto durante edição de justificativa
    setInterval(function() {
        if (@this.justificationActive && !@this.isOpenFrequency) {
            @this.set('isOpenFrequency', true);
        }
    }, 100);
});
</script>
