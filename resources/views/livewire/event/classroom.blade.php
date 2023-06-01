<div>
    <div class=" font-bold mb-2 flex items-center">
        <img src="{{ asset('svg/play-title.svg') }}" alt="Ícone">
        <div class="ml-2 text-3xl font-bold">
            {{$lessonData->title}}
        </div>
    </div>
    @if ($lessonData->video)
    <div class="card-white">
        <div class="w-full">
            <div style="position: relative; padding-bottom: 56.25%; height: 0;">
                <iframe style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;"
                    src="https://www.youtube.com/embed/{{$lessonData->video}}" frameborder="0"
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
            </div>

            <div class="card-white">
                @if ($lessonData->slide)
                <a href="{{ $lessonData->slide }}" class="block text-blue-500 hover:text-blue-700 mb-1" target="_blanck">PDF</a>
                @else
                <span class="text-red-500">Nenhum PDF cadastrado</span>
                @endif
            </div>
        </div>
    </div>

</div>
