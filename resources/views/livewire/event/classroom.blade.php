<div>
    <div class="flex flex-col md:flex-row items-center justify-between mb-2">
        <div class="flex items-center mb-2 md:mb-0">
            <img src="{{ asset('svg/module.svg') }}" alt="Ícone">
            <div class="ml-2 text-3xl font-bold">
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
                    <img src="{{ asset('svg/dowloard.svg') }}" alt="Ícone">
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
                            <svg class="w-4 h-4 text-indigo-900" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M5.25 9C5.25 5.27208 8.27208 2.25 12 2.25C15.7279 2.25 18.75 5.27208 18.75 9V16C18.75 16.4142 18.4142 16.75 18 16.75C17.5858 16.75 17.25 16.4142 17.25 16V9C17.25 6.1005 14.8995 3.75 12 3.75C9.10051 3.75 6.75 6.10051 6.75 9V17C6.75 18.7949 8.20507 20.25 10 20.25C11.7949 20.25 13.25 18.7949 13.25 17V10C13.25 9.30964 12.6904 8.75 12 8.75C11.3096 8.75 10.75 9.30964 10.75 10V16C10.75 16.4142 10.4142 16.75 10 16.75C9.58579 16.75 9.25 16.4142 9.25 16V10C9.25 8.48122 10.4812 7.25 12 7.25C13.5188 7.25 14.75 8.48122 14.75 10V17C14.75 19.6234 12.6234 21.75 10 21.75C7.37665 21.75 5.25 19.6234 5.25 17V9Z"
                                        fill="#030D45"></path>
                                </g>
                            </svg>
                            <a href="{{ $attachment->path }}" target="_blanck"
                                class=" font-bold text-xl text-indigo-900 hover:text-indigo-600 ml-2">{{ $attachment->name }}</a>
                        </div>

                        @can('admin')
                            <div class="flex items-center mr-2">
                                <livewire:attachment :lessonId='$lessonId' :attachmentId='$attachment->id' />
                            </div>
                        @endcan
                    </div>
                @empty
                    <span class="text-red-500">Nenhum anexo cadastrado</span>
                @endforelse
            </div>
        </div>
    </div>
    @if ($isOpenFrequency)
        @livewire('event-frequency', [$eventId, $lessonId])
    @endif
</div>
