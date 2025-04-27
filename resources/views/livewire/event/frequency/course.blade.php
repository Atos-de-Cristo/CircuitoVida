<div>
    <div class="flex flex-col md:flex-row items-start justify-between mb-2">
        <div class="flex items-center mb-2 md:mb-0">
            <x-icon-display class="w-6 h-6" />
            <div class="ml-2 text-xl font-bold">
                Controle de Frequência - {{ $event->name }}
            </div>
        </div>
        <div class="hidden md:inline">
            <ol class="flex items-center space-x-2 text-sm">
                <li class="breadcrumb-item">
                    <a href="{{ route('eventManager', ['eventId' => $eventId]) }}" class="text-blue-500 hover:underline">Voltar</a>
                </li>
                <span class="text-gray-500">/</span>
                <li class="breadcrumb-item active">Frequência</li>
            </ol>
        </div>
    </div>

    <div class="card-white py-4 px-4">
        <div class="flex flex-col md:flex-row justify-between items-center mb-4">
            <div class="w-full md:w-1/2 mb-4 md:mb-0">
                <input
                    wire:model.debounce.300ms="search"
                    placeholder="Buscar aluno..."
                    class="form-input peer h-full rounded-full bg-slate-150 px-4 pl-9 text-xs+ text-slate-800 ring-primary/50 hover:bg-slate-200 focus:ring dark:bg-navy-900/90 dark:text-navy-100 dark:placeholder-navy-300 dark:ring-accent/50 dark:hover:bg-navy-900 dark:focus:bg-navy-900 w-full max-w-lg"
                    type="text"
                >
            </div>
            <div class="flex items-center space-x-4">
                <span class="text-sm text-gray-600 dark:text-gray-300">Itens por página:</span>
                <select wire:model="perPage" wire:change="changePerPage($event.target.value)" class="form-select rounded-md text-sm dark:text-black">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
        </div>
        
        <!-- Visão para celulares (menos de 768px) -->
        <div class="md:hidden">
            @php
                $lessonsByModule = $lessons->sortBy('module.name')->groupBy('module_id');
                // Ordenar lições por data, com as mais recentes primeiro
                foreach ($lessonsByModule as $moduleId => $moduleLessons) {
                    $lessonsByModule[$moduleId] = $moduleLessons->sortByDesc('start_date');
                }
            @endphp

            <div class="space-y-4">
                @foreach($lessonsByModule as $moduleId => $moduleLessons)
                    @php
                        $moduleName = $moduleLessons->first()->module->name ?? 'Sem Módulo';
                    @endphp
                    <div class="mb-4">
                        <h3 class="font-bold text-base bg-gray-200 dark:bg-slate-600 p-2 rounded-t">{{ $moduleName }}</h3>
                        
                        <div class="space-y-3">
                            @foreach($moduleLessons as $lesson)
                                <div class="bg-white dark:bg-slate-800 shadow rounded-b mb-2">
                                    <div class="bg-gray-100 dark:bg-slate-700 p-2 border-b border-gray-200 dark:border-slate-600">
                                        <div class="font-semibold">{{ $lesson->title }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ \Carbon\Carbon::parse($lesson->start_date)->format('d/m/Y') }}
                                        </div>
                                    </div>
                                    
                                    <div class="p-2">
                                        @foreach($paginatedInscriptions as $inscription)
                                            @php
                                                $frequency = $lesson->frequency->where('user_id', $inscription->user->id)->first();
                                                $hasFrequency = $frequency ? true : false;
                                                $isJustified = $frequency && $frequency->is_justified;
                                                $isPresent = $frequency ? $frequency->is_present : false;
                                                $loadingKey = $inscription->user->id . '_' . $lesson->id;
                                            @endphp
                                            <div class="flex items-center justify-between py-2 border-b border-gray-100 dark:border-slate-700 last:border-0">
                                                <div class="flex items-center flex-grow mr-2">
                                                    @isset($inscription->user->profile_photo_url)
                                                        <img class="w-6 h-6 bg-black rounded-full mr-2 flex-shrink-0"
                                                            src="{{ asset($inscription->user->profile_photo_url) }}" width="24" height="24"
                                                            alt="Foto Perfil"
                                                        />
                                                    @endisset
                                                    <div class="font-medium text-sm break-words">{{ $inscription->user->name ?? 'N/A' }}</div>
                                                </div>
                                                <div class="flex items-center space-x-2">
                                                    <button 
                                                        class="text-yellow-500 hover:text-yellow-700 dark:text-yellow-400 dark:hover:text-yellow-300"
                                                        wire:click="openJustificationModal('{{ $inscription->user->id }}', '{{ $lesson->id }}', '{{ $inscription->id }}')"
                                                        wire:loading.attr="disabled"
                                                        title="{{ $isJustified ? 'Falta justificada' : 'Justificar falta' }}"
                                                    >
                                                        <div wire:loading wire:target="openJustificationModal('{{ $inscription->user->id }}', '{{ $lesson->id }}', '{{ $inscription->id }}')">
                                                            <svg class="animate-spin h-5 w-5 text-yellow-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                            </svg>
                                                        </div>
                                                        <div wire:loading.remove wire:target="openJustificationModal('{{ $inscription->user->id }}', '{{ $lesson->id }}', '{{ $inscription->id }}')">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 {{ $isJustified ? 'text-yellow-500 fill-yellow-500' : 'text-gray-400' }}" viewBox="0 0 20 20" fill="currentColor">
                                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                            </svg>
                                                        </div>
                                                    </button>
                                                    <label class="inline-flex items-center cursor-pointer">
                                                        <div wire:loading wire:target="toggleFrequency('{{ $inscription->user->id }}', '{{ $lesson->id }}', '{{ $inscription->id }}')">
                                                            <svg class="animate-spin h-5 w-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                            </svg>
                                                        </div>
                                                        <input
                                                            wire:loading.attr="disabled"
                                                            wire:loading.remove wire:target="toggleFrequency('{{ $inscription->user->id }}', '{{ $lesson->id }}', '{{ $inscription->id }}')"
                                                            type="checkbox"
                                                            class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                                            wire:click="toggleFrequency('{{ $inscription->user->id }}', '{{ $lesson->id }}', '{{ $inscription->id }}')"
                                                            @if($isPresent) checked @endif
                                                        >
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Visão para desktop (768px ou mais) -->
        <div class="hidden md:block overflow-x-auto">
            <table class="min-w-full bg-white dark:bg-slate-800 border border-gray-300 dark:border-slate-700">
                <thead>
                    <tr>
                        <th class="py-2 px-3 border-b border-r border-gray-300 dark:border-slate-700 bg-gray-100 dark:bg-slate-700 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider sticky left-0 z-10 bg-white dark:bg-slate-800 min-w-[220px] max-w-[300px]">
                            Aluno
                        </th>
                        @php
                            // Agrupar aulas por módulo
                            $lessonsByModule = $lessons->sortBy('module.name')->groupBy('module_id');
                        @endphp

                        @foreach($lessonsByModule as $moduleId => $moduleLessons)
                            @php
                                $moduleName = $moduleLessons->first()->module->name ?? 'Sem Módulo';
                            @endphp
                            <th colspan="{{ $moduleLessons->count() }}" class="py-2 px-3 border-b border-r border-gray-300 dark:border-slate-700 bg-gray-200 dark:bg-slate-600 text-center text-xs font-medium text-gray-800 dark:text-gray-200 uppercase tracking-wider">
                                {{ $moduleName }}
                            </th>
                        @endforeach
                    </tr>
                    <tr>
                        <th class="py-2 px-3 border-b border-r border-gray-300 dark:border-slate-700 bg-gray-100 dark:bg-slate-700 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider sticky left-0 z-10 bg-white dark:bg-slate-800">
                            <!-- Coluna de aluno já declarada acima -->
                        </th>
                        @foreach($lessonsByModule as $moduleId => $moduleLessons)
                            @foreach($moduleLessons->sortBy('title') as $lesson)
                                <th class="py-2 px-3 border-b border-r border-gray-300 dark:border-slate-700 bg-gray-100 dark:bg-slate-700 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                    <div>{{ $lesson->title }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ \Carbon\Carbon::parse($lesson->start_date)->format('d/m/Y') }}
                                    </div>
                                </th>
                            @endforeach
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($paginatedInscriptions as $inscription)
                    <tr>
                        <td class="py-2 px-3 border-b border-r border-gray-300 dark:border-slate-700 sticky left-0 min-w-[220px] max-w-[300px]">
                            <div class="flex items-center">
                                @isset($inscription->user->profile_photo_url)
                                    <img class="w-8 h-8 bg-black rounded-full mr-2 flex-shrink-0"
                                        src="{{ asset($inscription->user->profile_photo_url) }}" width="32" height="32"
                                        alt="Foto Perfil"
                                    />
                                @endisset
                                <div class="font-medium break-words">{{ $inscription->user->name ?? 'N/A' }}</div>
                            </div>
                        </td>
                        @foreach($lessonsByModule as $moduleId => $moduleLessons)
                            @foreach($moduleLessons->sortBy('title') as $lesson)
                                @php
                                    $frequency = $lesson->frequency->where('user_id', $inscription->user->id)->first();
                                    $hasFrequency = $frequency ? true : false;
                                    $isJustified = $frequency && $frequency->is_justified;
                                    $isPresent = $frequency ? $frequency->is_present : false;
                                    $loadingKey = $inscription->user->id . '_' . $lesson->id;
                                @endphp
                                <td class="py-2 px-3 border-b border-r border-gray-300 dark:border-slate-700 text-center">
                                    <div class="flex items-center justify-center space-x-4">
                                        <label class="inline-flex items-center cursor-pointer">
                                            <div wire:loading wire:target="toggleFrequency('{{ $inscription->user->id }}', '{{ $lesson->id }}', '{{ $inscription->id }}')">
                                                <svg class="animate-spin h-5 w-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                </svg>
                                            </div>
                                            <input
                                                wire:loading.attr="disabled"
                                                wire:loading.remove wire:target="toggleFrequency('{{ $inscription->user->id }}', '{{ $lesson->id }}', '{{ $inscription->id }}')"
                                                type="checkbox"
                                                class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                                wire:click="toggleFrequency('{{ $inscription->user->id }}', '{{ $lesson->id }}', '{{ $inscription->id }}')"
                                                @if($isPresent) checked @endif
                                            >
                                        </label>
                                        <button 
                                            class="text-yellow-500 hover:text-yellow-700 dark:text-yellow-400 dark:hover:text-yellow-300"
                                            wire:click="openJustificationModal('{{ $inscription->user->id }}', '{{ $lesson->id }}', '{{ $inscription->id }}', '{{ $inscription->user->name }}')"
                                            wire:loading.attr="disabled"
                                            title="{{ $isJustified ? 'Falta justificada: '.strip_tags($frequency->justification) : 'Justificar falta' }}"
                                        >
                                            <div wire:loading wire:target="openJustificationModal('{{ $inscription->user->id }}', '{{ $lesson->id }}', '{{ $inscription->id }}')">
                                                <svg class="animate-spin h-5 w-5 text-yellow-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                </svg>
                                            </div>
                                            <div wire:loading.remove wire:target="openJustificationModal('{{ $inscription->user->id }}', '{{ $lesson->id }}', '{{ $inscription->id }}')">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 {{ $isJustified ? 'text-yellow-500 fill-yellow-500' : 'text-gray-400' }}" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        </button>
                                    </div>
                                </td>
                            @endforeach
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            {{ $paginatedInscriptions->links() }}
        </div>
    </div>

    <!-- Modal de Justificativa -->
    @if($showJustificationModal)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white dark:bg-slate-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white dark:bg-slate-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100" id="modal-title">
                                Justificativa de Falta
                            </h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Aluno: {{ $selectedUserName }} <br />
                                Aula: {{ $lesson->title }}
                            </p>
                            <div class="mt-4 w-full">
                                <textarea
                                    wire:model="currentJustification"
                                    class="w-full h-32 p-2 border border-gray-300 dark:border-slate-600 rounded-md text-sm dark:bg-slate-700 dark:text-white"
                                    placeholder="Insira a justificativa da falta aqui..."
                                ></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 dark:bg-slate-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button 
                        wire:click="saveJustification" 
                        type="button" 
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm"
                    >
                        Salvar
                    </button>
                    <button 
                        wire:click="closeJustificationModal" 
                        type="button" 
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm dark:bg-slate-600 dark:text-gray-100 dark:border-slate-500 dark:hover:bg-slate-500"
                    >
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>


<style>
tr:hover td {
    background-color: #334155; /* Cor de fundo ao passar o mouse */
}

tr:hover td:first-child {
    background-color: #334155; /* Cor diferente para a primeira coluna */
}
</style> 