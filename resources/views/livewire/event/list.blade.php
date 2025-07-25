<div>
     @if (session()->has('message'))
    <x-alert-message :message="session('message')['text']" :messageType="session('message')['type']" />
    @endif
    <div class="flex flex-col md:flex-row items-start   justify-between mb-2">
        <div class="flex items-start mb-2 md:mb-0">
            <div class="ml-2 text-xl font-bold">
                Ativos
            </div>
        </div>
        <div class="hidden md:inline">
            <ol class="flex items-center space-x-2 text-sm">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}" class="text-blue-500 hover:underline">Home</a>
                </li>
                <span class="text-gray-500">/</span>
                <li class="breadcrumb-item active">Cursos</li>
            </ol>
        </div>
    </div>
    <x-card>
        <x-slot name="headerCard">
            <x-search-form placeholder="Buscar eventos..."/>
            @can('admin')
            <div class="mt-2 sm:mt-0 flex space-x-2">
                <button wire:click="create()" class="btn-primary">
                    <x-icon-plus class="w-4 h-4" />
                    <span class="ml-1">Evento</span>
                </button>
            </div>
            @endcan
        </x-slot>

        <x-slot name="contentCard">
            @foreach ($dataAll as $data)
            <div class="w-full md:w-1/2 lg:w-1/3 xl:w-1/4 p-2">
                <div class="bg-gray-100  max-w-sm  dark:bg-slate-800 overflow-hidden shadow rounded-lg flex flex-col ">
                    <div class="flex-shrink-0">
                        <img src="{{ asset(!empty($data->image) ? $data->image : 'images/curso_new.png') }}"
                            alt="Logo Evento {{ $data->name }}"
                            class="hover:scale-110 h-52 w-full object-cover rounded-t-lg cursor-pointer"
                            wire:click="manager({{ $data->id }})">
                    </div>
                    <div class="flex-grow p-4 flex flex-col justify-between">
                        <div class="mb-4">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ $data->name }}</h3>
                            <p class="text-sm text-gray-500 dark:text-white border-t my-1 py-1 border-slate-900">
                                Data: {{date('d/m/Y', strtotime($data->start_date))}} - {{date('d/m/Y', strtotime($data->end_date))}}
                            </p>
                            <p class="text-sm text-gray-500 dark:text-white border-y my-1 py-1 border-slate-900">Local: {{ $data->local }}</p>
                            <p class="text-sm text-gray-500 dark:text-white">Status do curso: {{ getStatusEvent($data->status) }}</p>
                        </div>
                        <div  class="dark:bg-slate-900 bg-slate-200 rounded-md py-3">
                            <div class="flex justify-between px-5 ">
                                <button wire:click.prevent="manager({{ $data->id }})" class="hover:scale-125">
                                    <x-icon-eye class="w-5 h-5" />
                                </button>
                                <button wire:click.prevent="edit({{ $data->id }})" class="hover:scale-125">
                                    <x-icon-pencil class="w-5 h-5" />
                                </button>
                                <livewire:delete-confirmation :itemId="$data->id" :service="'EventService'" :key="rand().$data->id"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </x-slot>
        <x-slot name="footerCard">
            {{ $dataAll->links() }}
        </x-slot>
    </x-card>

    <x-card>
        <x-slot name="headerCard">
            <div class="ml-2 text-xl font-bold">
                Finalizados
            </div>
        </x-slot>

        <x-slot name="contentCard">
            @foreach ($dataOld as $data)
            <div class="w-full md:w-1/2 lg:w-1/3 xl:w-1/4 p-2">
                <div class="bg-gray-100  max-w-sm  dark:bg-slate-800 overflow-hidden shadow rounded-lg flex flex-col ">
                    <div class="flex-shrink-0">
                        <img src="{{ asset(!empty($data->image) ? $data->image : 'images/curso_new.png') }}"
                            alt="Logo Evento {{ $data->name }}"
                            class="hover:scale-110 h-52 w-full object-cover rounded-t-lg cursor-pointer"
                            wire:click="manager({{ $data->id }})">
                    </div>
                    <div class="flex-grow p-4 flex flex-col justify-between">
                        <div class="mb-4">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ $data->name }}</h3>
                            <p class="text-sm text-gray-500 dark:text-white border-t my-1 py-1 border-slate-900">
                                Data: {{date('d/m/Y', strtotime($data->start_date))}} - {{date('d/m/Y', strtotime($data->end_date))}}
                            </p>
                            <p class="text-sm text-gray-500 dark:text-white border-y my-1 py-1 border-slate-900">Local: {{ $data->local }}</p>
                            <p class="text-sm text-gray-500 dark:text-white">Status do curso: {{ getStatusEvent($data->status) }}</p>
                        </div>
                        <div  class="dark:bg-slate-900 bg-slate-200 rounded-md py-3">
                            <div class="flex justify-between px-5 ">
                                <button wire:click.prevent="manager({{ $data->id }})" class="hover:scale-125">
                                    <x-icon-eye class="w-5 h-5" />
                                </button>
                                <button wire:click.prevent="edit({{ $data->id }})" class="hover:scale-125">
                                    <x-icon-pencil class="w-5 h-5" />
                                </button>
                                <livewire:delete-confirmation :itemId="$data->id" :service="'EventService'" :key="rand().$data->id"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </x-slot>
        <x-slot name="footerCard">
            {{ $dataAll->links() }}
        </x-slot>
    </x-card>
    @if ($isOpen)
    @include('livewire.event.create')
    @endif
</div>
