<div>
    @if (session()->has('message'))
        <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3"
            role="alert" x-data="{ showMessage: true }" x-show="showMessage" x-init="setTimeout(() => { showMessage = false; }, 4000)">
            <div class="flex">
                <div>
                    <p class="text-sm">{{ session('message') }}</p>
                </div>
            </div>
        </div>
    @endif
    <div class=" font-bold mb-4 flex items-center">
        <img src="{{ asset('svg/board.svg') }}" alt="Ícone">
        <div class="ml-2 text-3xl font-bold">
            {{ $event->name }}
        </div>
    </div>
    <div class="card-white">
        <div class="flex flex-col sm:flex-row justify-between items-center">
            <div>
                <div class="font-bold mb-4 flex items-center">
                    <img src="{{ asset('svg/teacher.svg') }}" alt="Ícone">
                    <span class="ml-2 font-bold">Monitores</span>
                </div>
                <div class="flex flex-col items-center sm:flex-row">
                    @forelse ($event->monitors as $monitor)
                        <div class="flex items-center mr-4">
                            <img class="w-8 h-8 bg-black rounded-full mr-2"
                                src="{{ asset($monitor->profile_photo_path) }}" width="32" height="32"
                                alt="{{ $monitor->name }}" />
                            <span
                                class="truncate text-sm font-medium group-hover:text-slate-800">{{ $monitor->name }}</span>
                        </div>
                    @empty
                        <span class="text-red-500">Monitor não cadastrado!</span>
                    @endforelse
                </div>
            </div>
            @can('admin')
                <div class="mt-2 sm:mt-0 flex space-x-2">
                    <button wire:click.prevent="createModule()" class="btn-primary">
                        <img src="{{ asset('svg/pasta-add.svg') }}" alt="Ícone">
                        <span class="ml-2">Módulos</span>
                    </button>
                    <button wire:click.prevent="openModalMonitors()" class="btn-primary">
                        <img src="{{ asset('svg/users-group.svg') }}" alt="Ícone">
                        <span class="ml-2">Monitores</span>
                    </button>
                </div>
            @endcan
        </div>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="sm:col-span-2 md:col-span-2">
            <div class="text-xl font-bold mb-4 flex items-center">
                <img src="{{ asset('svg/module.svg') }}" alt="Ícone">
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
                                    <button wire:click.prevent="editModule({{ $module->id }})" class="mr-2">
                                        <img src="{{ asset('svg/edit.svg') }}" alt="Ícone">
                                    </button>
                                    <button wire:click.prevent="deleteItem({{ $module->id }})" class="mr-5" @click.stop>
                                        <img src="{{ asset('svg/delete.svg') }}" alt="Ícone">
                                    </button>
                                @endcan
                                <div class="border-r border-gray-400 h-4"></div>
                                <svg x-show="!open" class="w-6 h-6 mx-2" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                                <svg x-show="open" class="w-6 h-6 mx-2" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 15l7-7 7 7" />
                                </svg>
                            </div>
                        </div>
                    </div>


                    <div x-show="open" class="bg-gray-50 p-2 transition-all mt-4 duration-300 ease-in-out rounded">
                        <div class="flex items-center mb-2 justify-between">
                            <h3 class="font-bold text-black mr-2">Título da Aula</h3>
                            <button wire:click.prevent="createLesson({{ $module->id }})"
                                class="btn-primary text-xs flex items-center">
                                <svg class="w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M11 2a1 1 0 01.993.883L12 3v4h4a1 1 0 01.117 1.993L16 9h-4v4a1 1 0 01-1.993.117L10 13V9H6a1 1 0 01-.117-1.993L6 7h4V3a1 1 0 011-1z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span>Aula</span>
                            </button>
                        </div>
                        <div class="border-t border-gray-200 pb-2">
                            @forelse ($module->lessons as $lesson)
                                <div class="border-t border-gray-200 pb-2 py-2 flex items-center justify-between">
                                    <div class="flex items-center">
                                        <img src="{{ asset('svg/play-lesson.svg') }}" alt="Ícone"
                                            class="text-red-500">
                                        <a href="{{ route('classroom', ['id' => $lesson->id, 'eventId' => $eventId]) }}"
                                            class="text-blue-500 hover:text-blue-700 ml-2">{{ $lesson->title }}</a>
                                    </div>
                                    @can('admin')
                                        <div class="flex items-center mr-2">
                                            <button wire:click.prevent="editLesson({{ $lesson->id }})" class="mr-5">
                                                <img src="{{ asset('svg/edit.svg') }}" alt="Ícone">
                                            </button>
                                            <button wire:click.prevent="dellLesson({{ $lesson->id }})">
                                                <img src="{{ asset('svg/delete.svg') }}" alt="Ícone">
                                            </button>
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
                <img src="{{ asset('svg/student.svg') }}" alt="Ícone">
                <span class="ml-2">ALUNOS</span>
            </div>
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                @forelse ($event->inscriptions as $aluno)
                    <div class="flex items-center mb-4">
                        <img class="w-8 h-8 bg-black rounded-full mr-2"
                            src="{{ asset($aluno->user->profile_photo_url) }}" width="32" height="32"
                            alt="{{ $aluno->user->name }}" />
                        <span
                            class="truncate ml-2 text-sm font-medium group-hover:text-slate-800">{{ $aluno->user->name }}</span>
                    </div>
                @empty
                    <span class="text-red-500">Nenhuma inscrição realizada</span>
                @endforelse
            </div>
        </div>
    </div>
    @if ($isOpenModule)
        @include('livewire.event.module-create')
    @endif
    @if ($isOpenLesson)
        @include('livewire.event.lesson-create')
    @endif
    @if ($isOpenActivity)
        @livewire('event-activity', [$eventId, $lessonId])
    @endif
    @if ($isOpenMonitors)
        @livewire('event-monitors', [$eventId])
    @endif

    @if ($showConfirmationPopup)
        <div class="fixed inset-0 flex items-center justify-center z-50">
            <div
                class="bg-white p-4 rounded shadow absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                <h2 class="text-lg font-bold mb-4">Confirmação</h2>
                <p>Deseja realmente excluir este item?</p>
                <div class="flex justify-end mt-4">
                    <button wire:click="confirmDelete"
                        class="px-4 py-2 bg-red-500 text-white rounded">Confirmar</button>
                    <button wire:click="$set('showConfirmationPopup', false)"
                        class="px-4 py-2 bg-gray-300 rounded">Cancelar</button>
                </div>
            </div>
        </div>
    @endif

</div>
