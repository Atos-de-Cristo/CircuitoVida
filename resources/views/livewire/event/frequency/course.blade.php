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
                                                $hasFrequency = $lesson->frequency->where('user_id', $inscription->user->id)->count() > 0;
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
                                                <label class="inline-flex items-center cursor-pointer">
                                                    <input
                                                        type="checkbox"
                                                        class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                                        wire:click="toggleFrequency('{{ $inscription->user->id }}', '{{ $lesson->id }}', '{{ $inscription->id }}')"
                                                        @if($hasFrequency) checked @endif
                                                    >
                                                </label>
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
                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-700">
                        <td class="py-2 px-3 border-b border-r border-gray-300 dark:border-slate-700 sticky left-0 z-10 bg-white dark:bg-slate-800 min-w-[220px] max-w-[300px]">
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
                                <td class="py-2 px-3 border-b border-r border-gray-300 dark:border-slate-700 text-center">
                                    @php
                                        $hasFrequency = $lesson->frequency->where('user_id', $inscription->user->id)->count() > 0;
                                    @endphp
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input
                                            type="checkbox"
                                            class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                            wire:click="toggleFrequency('{{ $inscription->user->id }}', '{{ $lesson->id }}', '{{ $inscription->id }}')"
                                            @if($hasFrequency) checked @endif
                                        >
                                    </label>
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
</div> 