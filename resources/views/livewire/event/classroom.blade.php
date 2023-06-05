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
                    <button wire:click.prevent="createModule()" class="btn-primary">
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
            <div class="text-xl font-bold mb-4 flex items-center">
                <img src="{{ asset('svg/activits.svg') }}" alt="Ícone">
                <span class="ml-2">Atividades</span>
                <button wire:click.prevent="addActivity" class="btn-primary text-xs ml-2">
                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 5v14M5 12h14" />
                    </svg>
                </button>
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
            <div class="text-xl font-bold mb-4 flex items-center">
                <img src="{{ asset('svg/dowloard.svg') }}" alt="Ícone">
                <span class="ml-2">Materiais</span>
                <button wire:click.prevent="attachFile" class="btn-primary text-xs ml-2">
                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path
                            d="M12 2C6.477 2 2 6.477 2 12c0 5.523 4.477 10 10 10s10-4.477 10-10c0-5.523-4.477-10-10-10zm0 12a2 2 0 100-4 2 2 0 000 4z" />
                        <path d="M14.828 9.172a4 4 0 10-5.656 5.656" />
                    </svg>
                </button>
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


</div>
