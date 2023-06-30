<div>
    <div class="flex flex-col md:flex-row items-center justify-between mb-2">
        <div class="flex items-center mb-2 md:mb-0">
            <x-svg.module size="h-8 w-8" />
            <div class="ml-2 text-xl font-bold">
                {{ $lessonData->module->name }}
            </div>
        </div>
        <div class=" hidden md:inline">
            <ol class="flex items-center space-x-2  text-sm">
                <li class="breadcrumb-item">
                    <a href="{{ url()->previous() }}" class="text-blue-500 hover:underline">Voltar</a>
                </li>
                <span class="text-gray-500">/</span>
                <li class="breadcrumb-item active">Atividades &amp; Materiais</li>
            </ol>
        </div>
    </div>
    <div class="card-white">
        <div class="flex flex-col sm:flex-row justify-between items-center">
            <div class="font-bold  flex items-center">
                <x-svg.play-lesson size="h-8 w-8" />
                {{ $lessonData->title }}
            </div>
            @can('admin')
            @livewire('event-frequency', [$eventId, $lessonId])
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
                    <x-svg.activits />
                    <span class="ml-2">Atividades</span>
                </div>
                @can('admin')
                    <livewire:event-activity-actions :activityId="null" :lessonId="$lessonId">
                @endCan
            </div>
            <div class="card-white h-48 overflow-y-auto">
                <div class="w-full">
                    @livewire('event-activity-list', ['lessonId' => $lessonId])
                </div>
            </div>
        </div>
        <div class="sm:col-span-2 md:col-span-1">
            <div class="text-xl font-bold mb-4 flex items-center justify-between">
                <div class="flex items-center">
                    <x-svg.dowloard />
                    <span class="ml-2">Materiais</span>
                </div>
                @can('admin')
                    <livewire:attachment :lessonId='$lessonId' :attachmentId='null' />
                @endCan
            </div>
            <div class="card-white  h-48 overflow-y-auto">
                @forelse ($lessonData->attachments as $attachment)
                    <div class="flex items-center justify-between ml-3 ">
                        <div class="flex items-center">
                            <x-svg.anexo size="h-5 w-5" />
                            <a href="{{ $attachment->path }}" target="_blank" class="font-bold text-md text-blue-500 hover:underline ml-2">
                                {{ $attachment->name }}.{{ pathinfo($attachment->path, PATHINFO_EXTENSION) }}
                            </a>
                        </div>
                        @can('admin')
                            <div class="flex items-center mr-2">
                                <livewire:attachment :lessonId='$lessonId' :attachmentId='$attachment->id' :key="time().$attachment->id" />
                            </div>
                        @endcan
                    </div>
                @empty
                    <span class="text-red-500">Nenhum anexo cadastrado</span>
                @endforelse
            </div>
        </div>
    </div>

</div>
