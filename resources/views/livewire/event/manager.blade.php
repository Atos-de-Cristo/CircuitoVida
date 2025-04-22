<div>
    @if (session()->has('message'))
        <x-alert-message :message="session('message')['text']" :messageType="session('message')['type']" />
    @endif

    <div class="flex flex-col md:flex-row items-start justify-between mb-2">
        <div class="flex items-center mb-2 md:mb-0">
            <x-icon-display class="w-6 h-6" />
            <div class="ml-2 text-xl font-bold">
                {{ $event->name }}
            </div>
        </div>
        <div class=" hidden md:inline">
            <ol class="flex items-center space-x-2  text-sm">
                <li class="breadcrumb-item">
                    <a href="{{ url()->previous() }}" class=" text-blue-500 hover:underline">Voltar</a>
                </li>
                <span class="text-gray-500">/</span>
                <li class="breadcrumb-item active">Módulos &amp; Aulas</li>
            </ol>
        </div>
    </div>
    <div class="card-white px-4 py-2 flex flex-col md:flex-row">
        <div class="flex flex-1 flex-col sm:flex-row justify-between items-center">
            <div>
                <div class="font-bold px-2 mb-2 flex items-center">
                    <x-icon-person-chalkboard class="w-6 h-6" />
                    <span class="ml-2 font-bold">Monitores</span>
                </div>
                <div class="flex flex-wrap gap-1 items-center sm:flex-row mb-5">
                    @forelse ($event->monitors as $monitor)
                    <div class="flex items-center ml-2">
                        <img class="w-8 h-8 bg-black rounded-full " src="{{ asset($monitor->profile_photo_url) }}"
                            width="32" height="32" alt="{{ $monitor->name }}" />
                        <a class="font-bold cursor-pointer text-md text-blue-500 hover:underline ml-2"
                            wire:click="sendMessage({{$monitor->id}})">
                            <span class="truncate  text-sm font-medium group-hover:text-slate-800">{{ $monitor->name
                                }}</span>
                        </a>
                    </div>
                    @empty
                    <span class="text-red-500">Monitor não cadastrado!</span>
                    @endforelse
                </div>
            </div>
            @can('admin')
                <div class="flex justify-center flex-wrap gap-2">
                    <livewire:event-module :eventId='$eventId' :key="rand()"/>
                    <livewire:event-monitors :eventId='$eventId' :key="rand()">
                    <button wire:click="$emit('openSendMessageRoom', {{$eventId}})" class="btn-primary sm:px-2">
                        <x-icon-bell class="w-4 h-4" />
                        <span class="ml-2">Notificação</span>
                    </button>
                    <livewire:copying-course-data :eventId='$eventId' :key="rand()">
                    <a href="{{ route('courseFrequency', ['eventId' => $eventId]) }}" class="btn-primary sm:px-2">
                        <x-icon-check class="w-4 h-4" />
                        <span class="ml-2">Frequência</span>
                    </a>
                </div>
            @endcan
            @can('monitorEvent', $eventId)
                <div class="flex justify-center flex-wrap gap-2">
                    <button wire:click="$emit('openSendMessageRoom', {{$eventId}})" class="btn-primary sm:px-2">
                        <x-icon-bell class="w-4 h-4" />
                        <span class="ml-2">Notificação</span>
                    </button>
                    <a href="{{ route('courseFrequency', ['eventId' => $eventId]) }}" class="btn-primary sm:px-2">
                        <x-icon-check class="w-4 h-4" />
                        <span class="ml-2">Frequência</span>
                    </a>
                </div>
            @endcan
        </div>
        @cannot('monitorEvent', $eventId)
        @can('aluno')
            <div class="flex flex-col items-center">
                <div class="text-xl font-bold mb-4 flex items-center justify-between">
                    <div class="flex items-center">
                        <x-icon-cloud-arrow-up  />
                        <span class="ml-2">Enviar trabalho</span>
                    </div>
                    <livewire:attachment :eventId='$eventId' :userId='auth()->user()->id' :key="rand()" />
                </div>
                <div class="px-4">
                    @forelse ($event->attachments->where('user_id', auth()->user()->id) as $attachment)
                    <div class="flex items-center justify-between ">
                        <div class="flex items-center">
                            <x-icon-paperclip  />
                            <a href="{{ $attachment->path }}" target="_blank"
                                class="font-bold text-md text-blue-500 hover:underline ml-2">
                                {{ $attachment->name }}.{{ pathinfo($attachment->path, PATHINFO_EXTENSION) }}
                            </a>
                        </div>
                        @can('admin')
                        <div class="flex items-center mr-2">
                            <livewire:attachment :eventId='$eventId' :attachmentId='$attachment->id'
                                :key="rand().$attachment->id" />
                        </div>
                        @endcan
                    </div>
                    @empty
                    <span class="text-red-500">Nenhum anexo cadastrado</span>
                    @endforelse
                </div>
            </div>
        @endcan
        @endcannot
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="sm:col-span-2 md:col-span-2">
            <div class="text-xl font-bold mb-4 flex items-center">
                <x-icon-cubes class="w-8 h-8" />
                <span class="ml-2">MODULOS</span>
            </div>
            @forelse ($event->modules as $module)
                <div x-data="{ open: false }" class="card-white py-2 px-4">
                    <div @click="open = !open" class="cursor-pointer">
                        <div class="flex items-center justify-between">
                            <span class="text-xl">
                                {{ $module->name }}
                            </span>
                            <div class="flex items-center space-x-2">
                                @can('admin')
                                    <livewire:event-module :eventId='$eventId' :moduleId='$module->id' :key='$module->id'/>
                                @endcan
                                <div class="border-r border-gray-400 h-4"></div>
                                <x-icon-angle-down x-show="!open" class="w-6 h-6" />
                                <x-icon-angle-up x-show="open" class="w-6 h-6" />
                            </div>
                        </div>
                    </div>
                    <div x-show="open"
                        class="bg-gray-50 dark:bg-slate-600 p-2 transition-all mt-4 duration-300 ease-in-out rounded">
                        <div class="flex items-center mb-2 justify-between">
                            <h3 class="font-bold text-black dark:text-white mr-2">Título da Aula</h3>
                            @can('admin')
                            <livewire:event-lesson :eventId="$eventId" :moduleId="$module->id" :key="rand().$module->id" />
                            @endcan
                        </div>
                        <div class="border-t border-gray-200 pb-2">
                            @forelse ($module->lessons->sortBy('title') as $lesson)
                            <div class="border-t border-gray-200 pb-2 py-2 flex items-center justify-between">
                                <div class="flex items-center">
                                    <x-icon-circle-play class="w-5 h-5" />
                                    <div class="flex flex-col">
                                        @if (
                                            Carbon\Carbon::parse($lesson->start_date) <= Carbon\Carbon::parse(date('Y-m-d H:i:s'))
                                            && Carbon\Carbon::parse($lesson->end_date) > Carbon\Carbon::parse(date('Y-m-d H:i:s'))
                                        )
                                            <a href="{{ route('classroom', ['id' => $lesson->id, 'eventId' => $eventId]) }}"
                                                class="font-bold text-md text-blue-500 hover:underline ml-2"
                                                x-data="{ open: null }">
                                                {{ $lesson->title }}
                                            </a>
                                        @else
                                            @can('admin')
                                                <a
                                                    href="{{ route('classroom', ['id' => $lesson->id, 'eventId' => $eventId]) }}"
                                                    class="font-bold text-md text-blue-500 hover:underline ml-2"
                                                    x-data="{ open: null }"
                                                >
                                                    {{ $lesson->title }}
                                                    <span class="italic text-sm text-blue-400">
                                                        liberada
                                                        {{\Carbon\Carbon::parse($lesson->start_date)->format('d/m/Y H:i:s')}}
                                                            à
                                                        {{\Carbon\Carbon::parse($lesson->end_date)->format('d/m/Y H:i:s')}}
                                                    </span>
                                                </a>
                                            @else
                                                @can('monitorEvent', $eventId)
                                                    <a
                                                        href="{{ route('classroom', ['id' => $lesson->id, 'eventId' => $eventId]) }}"
                                                        class="font-bold text-md text-blue-500 hover:underline ml-2"
                                                        x-data="{ open: null }"
                                                    >
                                                        {{ $lesson->title }}
                                                        <span class="italic text-sm text-blue-400">
                                                            liberada
                                                            {{\Carbon\Carbon::parse($lesson->start_date)->format('d/m/Y H:i:s')}}
                                                                à
                                                            {{\Carbon\Carbon::parse($lesson->end_date)->format('d/m/Y H:i:s')}}
                                                        </span>
                                                    </a>
                                                @else
                                                    <p class="ml-2">
                                                        {{ $lesson->title }}
                                                        <span class="italic text-sm text-blue-400">
                                                            {{\Carbon\Carbon::parse($lesson->start_date)->format('d/m/Y H:i:s')}}
                                                                à
                                                            {{\Carbon\Carbon::parse($lesson->end_date)->format('d/m/Y H:i:s')}}
                                                        </span>
                                                    </p>
                                                @endcan
                                            @endcan
                                        @endif
                                    </div>
                                </div>
                                @can('admin')
                                <div class="flex items-center mr-2">
                                    <livewire:event-lesson :eventId="$eventId" :moduleId="$module->id"
                                        :lessonId="$lesson->id" :key="rand().$lesson->id" />
                                </div>
                                @endcan
                            </div>
                            @empty
                                <span class="text-red-500">Nenhuma aula cadastrada</span>
                            @endforelse
                        </div>
                    </div>
                </div>
            @empty
                <div class="card-white  py-2 px-4">
                    <span class="text-red-500">Nenhum módulo cadastrado</span>
                </div>
            @endforelse
        </div>
        <div class="sm:col-span-2 md:col-span-1">
            <div class="text-xl font-bold mb-4 flex items-center justify-between">
                <div class="flex items-center">
                    <x-icon-cloud-arrow-up  />
                    <span class="ml-2">Material de apoio</span>
                </div>
                @cannot('aluno')
                <livewire:attachment :eventId='$eventId' :attachmentId='null' :key="rand()" />
                @endCan
            </div>
            <div
                class="bg-white border-t-2 dark:border-indigo-900 dark:bg-slate-700 overflow-hidden shadow-xl rounded-md mt-2 mb-4">
                <div class="max-h-40 overflow-auto px-4 py-4">
                    <h3>Geral:</h3>
                    @foreach ($event->attachments->where('user_id', null) as $attachment)
                    <div class="flex items-center justify-between ">
                        <div class="flex items-center">
                            <x-icon-paperclip  />
                            <a href="{{ $attachment->path }}" target="_blank"
                                class="font-bold text-md text-blue-500 hover:underline ml-2">
                                {{ $attachment->name }}.{{ pathinfo($attachment->path, PATHINFO_EXTENSION) }}
                            </a>
                        </div>
                        @can('admin')
                        <div class="flex items-center mr-2">
                            <livewire:attachment :eventId='$eventId' :attachmentId='$attachment->id'
                                :key="rand().$attachment->id" />
                        </div>
                        @endcan
                    </div>
                    @endforeach
                    @can('monitorEvent', $eventId)
                        <h3 class="mt-2">Individual:</h3>
                        @foreach ($event->attachments->whereNotNull('user_id')->sortBy(function ($attachment) {
                            return $attachment->user->name;
                        }) as $attachment)
                            <div class="flex items-center justify-between ">
                                <div class="flex items-center">
                                    <x-icon-paperclip  />
                                    <a href="{{ $attachment->path }}" target="_blank"
                                        class="font-bold text-md text-blue-500 hover:underline ml-2">
                                        {{ $attachment->user->name }}
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    @endCan
                    @can('admin')
                        <h3 class="mt-2">Individual:</h3>
                        @foreach ($event->attachments->whereNotNull('user_id')->sortBy(function ($attachment) {
                            return $attachment->user->name;
                        }) as $attachment)
                            <div class="flex items-center justify-between ">
                                <div class="flex items-center">
                                    <x-icon-paperclip  />
                                    <a href="{{ $attachment->path }}" target="_blank"
                                        class="font-bold text-md text-blue-500 hover:underline ml-2">
                                        {{ $attachment->user->name }}
                                    </a>
                                </div>
                                <div class="flex items-center mr-2">
                                    <livewire:attachment :eventId='$eventId' :attachmentId='$attachment->id'
                                        :key="rand().$attachment->id" />
                                </div>
                            </div>
                        @endforeach
                    @endCan
                </div>
            </div>
            <div class="text-xl font-bold mb-4 flex items-center justify-between">
                <div class="flex">
                    <x-icon-graduation-cap class="w-8 h-8" />
                    <span class="ml-2">ALUNOS</span>
                </div>
            </div>
            <livewire:event-alunos :id="$event->id" :key="rand()" />
        </div>
    </div>
</div>
