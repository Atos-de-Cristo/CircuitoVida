<div>
    <div class=" font-bold mb-2 flex items-center">
        <img src="{{ asset('svg/module.svg') }}" alt="Ícone">
        <div class="ml-2 text-3xl font-bold">
            {{ $lessonData->module->name }}
        </div>
    </div>
    <div class="card-white">
        <div class="flex flex-col sm:flex-row justify-between items-center">
            <div class="font-bold  flex items-center">
                <img src="{{ asset('svg/play-title.svg') }}" alt="Ícone" class="w-12 h-12">
                {{ $lessonData->title }}
            </div>
            @can('admin')
                <div class="mt-2 sm:mt-0 flex space-x-2">
                    <button wire:click.prevent="openModalFrequency()" class="btn-primary">
                        <img src="{{ asset('svg/checklist.svg') }}" alt="Ícone" class="w-4 h-4">
                        <span class="ml-2">Fequência</span>
                    </button>
                </div>
            @endcan
        </div>
    </div>
    @if ($lessonData->video)
        <div class="card-white">
            <div class="w-full">
                <div style="position: relative; padding-bottom: 56.25%; height: 0;">
                    <iframe style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;"
                        src="https://www.youtube.com/embed/{{ $lessonData->video }}" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        allowfullscreen></iframe>
                </div>
            </div>
        </div>
    @endif
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div class="sm:col-span-2 md:col-span-1">
            <div class="text-xl font-bold mb-4 flex items-center justify-between">
                <div class="flex items-center">
                    <img src="{{ asset('svg/activits.svg') }}" alt="Ícone">
                    <span class="ml-2">Atividades</span>
                </div>
                @can('admin')
                    <button wire:click.prevent="openModalActivity" class="btn-primary text-xs ml-2">
                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 5v14M5 12h14" />
                        </svg>
                    </button>
                @endCan
            </div>
            <div class="card-white">
                <div class="w-full md:w-1/2">
                    @forelse ($lessonData->activities as $activity)
                        <a href="{{ $activity->id }}"
                            class="block text-blue-500 hover:text-blue-700 mb-1">{{ $activity->title }}</a>
                    @empty
                        <span class="text-red-500">Nenhuma atividade cadastrada</span>
                    @endforelse
                </div>
            </div>
        </div>
        <div class="sm:col-span-2 md:col-span-1">
            <div class="text-xl font-bold mb-4 flex items-center justify-between">
                <div class="flex items-center">
                    <img src="{{ asset('svg/dowloard.svg') }}" alt="Ícone">
                    <span class="ml-2">Materiais</span>
                </div>
                @can('admin')
                    <button wire:click.prevent="attachFile" class="btn-primary text-xs ml-2">
                        <svg fill="#ffffff" class="w-4 h-4" viewBox="0 0 32 32" version="1.1"
                            xmlns="http://www.w3.org/2000/svg" stroke="#ffffff">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <title>upload-cloud</title>
                                <path
                                    d="M0 16v-1.984q0-3.328 2.336-5.664t5.664-2.336q1.024 0 2.176 0.352 0.576-2.752 2.784-4.544t5.056-1.824q3.296 0 5.632 2.368t2.368 5.632q0 0.896-0.32 2.048 0.224-0.032 0.32-0.032 2.464 0 4.224 1.76t1.76 4.224v2.016q0 2.496-1.76 4.224t-4.224 1.76h-0.384q0.288-0.8 0.352-1.44 0.096-1.312-0.32-2.56t-1.408-2.208l-4-4q-1.76-1.792-4.256-1.792t-4.224 1.76l-4 4q-0.96 0.96-1.408 2.24t-0.32 2.592q0.032 0.576 0.256 1.248-2.72-0.608-4.512-2.784t-1.792-5.056zM10.016 22.208q-0.096-0.96 0.576-1.6l4-4q0.608-0.608 1.408-0.608 0.832 0 1.408 0.608l4 4q0.672 0.64 0.608 1.6-0.032 0.288-0.16 0.576-0.224 0.544-0.736 0.896t-1.12 0.32h-1.984v6.016q0 0.832-0.608 1.408t-1.408 0.576-1.408-0.576-0.576-1.408v-6.016h-2.016q-0.608 0-1.088-0.32t-0.768-0.896q-0.096-0.288-0.128-0.576z">
                                </path>
                            </g>
                        </svg>
                    </button>
                @endCan
            </div>
            <div class="card-white">
                @if ($lessonData->slide)
                    <a href="{{ $lessonData->slide }}" class="block text-blue-500 hover:text-blue-700 mb-1"
                        target="_blank">PDF</a>
                @else
                    <span class="text-red-500">Nenhum PDF cadastrado</span>
                @endif
            </div>
        </div>
    </div>
    @if ($isOpenFrequency)
        @livewire('event-frequency', [$eventId, $lessonId])
    @endif
    @if ($isOpenActivity)
        @livewire('event-activity-create', [$eventId, $lessonId])
    @endif
</div>
