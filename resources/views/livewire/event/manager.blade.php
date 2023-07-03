<div>

    @if (session()->has('message'))
    <div class="bg-teal-100  border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3" role="alert"
        x-data="{ showMessage: true }" x-show="showMessage" x-init="setTimeout(() => { showMessage = false; }, 1000)">
        <div class="flex">
            <div>
                <p class="text-sm">{{ session('message') }}</p>
            </div>
        </div>
    </div>
    @endif

    <div class="flex flex-col md:flex-row items-center justify-between mb-2">
        <div class="flex items-center mb-2 md:mb-0">
            <x-svg.board />

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


    <div class="card-white">
        <div class="flex flex-col sm:flex-row justify-between items-center">
            <div>
                <div class="font-bold mb-4 flex items-center">
                    <x-svg.teacher size="h-5 w-5" />
                    <span class="ml-2 font-bold">Monitores</span>
                </div>
                <div class="flex flex-col items-center sm:flex-row">
                    @forelse ($event->monitors as $monitor)
                    <div class="flex items-center mr-4">
                        <img class="w-8 h-8 bg-black rounded-full mr-2" src="{{ asset($monitor->profile_photo_path) }}"
                            width="32" height="32" alt="{{ $monitor->name }}" />
                        <span class="truncate text-sm font-medium group-hover:text-slate-800">{{ $monitor->name
                            }}</span>
                    </div>
                    @empty
                    <span class="text-red-500">Monitor não cadastrado!</span>
                    @endforelse
                </div>
            </div>
            @can('admin')
            <div class="mt-2 sm:mt-0 flex space-x-2">
                <button wire:click.prevent="createModule()" class="btn-primary">
                    <x-svg.pasta-add size="h-5 w-5" color="fill-current text-white " />
                    <span class="ml-2">Módulos</span>
                </button>
                <livewire:event-monitors :eventId='$eventId' :key="rand()">
            </div>
            @endcan
        </div>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="sm:col-span-2 md:col-span-2">
            <div class="text-xl font-bold mb-4 flex items-center">
                <x-svg.module size="h-8 w-8" />
                <span class="ml-2">MODULOS</span>
            </div>
            @forelse ($event->modules as $module)
            <div x-data="{ open: false }" class="card-white py-4">
                <div @click="open = !open" class="cursor-pointer">
                    <div class="flex items-center justify-between">
                        <span class="text-xl">
                            {{ $module->name }}
                        </span>
                        <div class="flex items-center space-x-2">
                            @can('admin')
                            <button wire:click.prevent="editModule({{ $module->id }})" class="mr-2 hover:scale-110"  @click.stop>
                                <x-svg.edit />
                            </button>
                            <button wire:click.prevent="deleteItem({{ $module->id }})" class="mr-5 hover:scale-110" @click.stop>
                                <x-svg.delete />
                            </button>
                            @endcan
                            <div class="border-r border-gray-400 h-4"></div>
                            <svg x-show="!open" class="w-6 h-6 mx-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                            <svg x-show="open" class="w-6 h-6 mx-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 15l7-7 7 7" />
                            </svg>
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
                        @forelse ($module->lessons as $lesson)
                        <div class="border-t border-gray-200 pb-2 py-2 flex items-center justify-between">
                            <div class="flex items-center">
                                <x-svg.play-lesson size="h-5 w-5" />
                                <div class="flex flex-col">
                                    @if ($lesson->start_date && $lesson->end_date)
                                    @if (
                                    Carbon\Carbon::parse($lesson->start_date) <= Carbon\Carbon::parse(date('Y-m-d
                                        H:i:s')) && Carbon\Carbon::parse($lesson->end_date) >
                                        Carbon\Carbon::parse(date('Y-m-d H:i:s'))
                                        )
                                        <a href="{{ route('classroom', ['id' => $lesson->id, 'eventId' => $eventId]) }}"
                                            class="font-bold text-md text-blue-500 hover:underline ml-2"
                                            x-data="{ open: null }">
                                            {{ $lesson->title }}
                                        </a>
                                        @else
                                        @can('admin')
                                        <a href="{{ route('classroom', ['id' => $lesson->id, 'eventId' => $eventId]) }}"
                                            class="font-bold text-md text-blue-500 hover:underline ml-2"
                                            x-data="{ open: null }">
                                            {{ $lesson->title }} <span class="italic text-sm text-blue-400">liberada {{
                                                \Carbon\Carbon::parse($lesson->start_date)->format('d/m/Y H:m:s')}} à {{
                                                \Carbon\Carbon::parse($lesson->end_date)->format('d/m/Y H:m:s')}}</span>
                                        </a>
                                        @else
                                        <p class="ml-2">{{ $lesson->title }} <span
                                                class="italic text-sm text-blue-400">{{
                                                \Carbon\Carbon::parse($lesson->start_date)->format('d/m/Y H:m:s')}} à {{
                                                \Carbon\Carbon::parse($lesson->end_date)->format('d/m/Y H:m:s')}}</span>
                                        </p>
                                        @endcan
                                        @endif
                                        @else
                                        <a href="{{ route('classroom', ['id' => $lesson->id, 'eventId' => $eventId]) }}"
                                            class="font-bold text-md text-blue-500 hover:underline ml-2"
                                            x-data="{ open: null }">
                                            {{ $lesson->title }}
                                        </a>
                                        @endif
                                        <small class="ml-2">{{$lesson->description}}</small>
                                </div>
                            </div>
                            @can('admin')
                            <div class="flex items-center mr-2">
                                <livewire:event-lesson :eventId="$eventId" :moduleId="$module->id" :lessonId="$lesson->id" :key="rand().$lesson->id" />
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
            <div class="card-white  py-4">
                <span class="text-red-500">Nenhum módulo cadastrado</span>
            </div>
            @endforelse
        </div>
        <div class="sm:col-span-2 md:col-span-1">
            <div class="text-xl font-bold mb-4 flex items-center">
                <x-svg.student />
                <span class="ml-2">ALUNOS</span>
            </div>
            <livewire:event-alunos :id="$event->id" :key="rand()"/>
        </div>
    </div>
    @if ($isOpenModule)
        @include('livewire.event.module-create')
    @endif
    @if ($showConfirmationPopup)
    <div class="fixed z-40 inset-0 overflow-y-auto ease-out duration-400">
        <div class="flex items-end justify-start min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <!-- This element is to trick the browser into centering the modal contents. -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>

            <div class="fixed inset-0 flex flex-col items-center justify-start z-50 mt-8">
                <div class="bg-slate-800 p-4  rounded-md shadow-lg top-0">
                    <h2 class="text-lg text-white font-bold mb-4">Confirmação</h2>
                    <p class="text-white">Deseja realmente excluir este item?</p>
                    <div class="flex justify-end mt-4">
                        <button wire:click="confirmDelete"
                            class="px-4 py-2 bg-red-500 text-white rounded">Confirmar</button>
                        <button wire:click="$set('showConfirmationPopup', false)"
                            class=" ml-3 px-4 py-2 bg-gray-300 rounded">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
