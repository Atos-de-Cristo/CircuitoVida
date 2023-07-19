<div>
    @if (session()->has('message'))
    <x-alert-message :message="session('message')['text']" :messageType="session('message')['type']" />
    @endif

    <div class="flex flex-col md:flex-row items-center justify-between mb-2">
        <div class="flex items-center mb-2 md:mb-0">
            <div class="ml-2 text-xl font-bold">
                Lista de Eventos
            </div>
        </div>
        <div class="hidden md:inline">
            <ol class="flex items-center space-x-2 text-sm">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}" class="text-blue-500 hover:underline">Dashboard</a>
                </li>
                <span class="text-gray-500">/</span>
                <li class="breadcrumb-item active">Cursos</li>
            </ol>
        </div>
    </div>

    <div class="card-white">
        <div class="flex flex-col mb-4 sm:flex-row justify-between items-center">

            <div class="font-bold flex items-center">
                <div class="relative mr-4 flex">
                    <input wire:model.debounce.300ms.page="search" wire:keydown="search" placeholder="Buscar eventos..."
                        class="input-form-search" type="text">

                    <x-svg.search />
                </div>
            </div>

            @can('admin')
            <div class="mt-2 sm:mt-0 flex space-x-2">
                <button wire:click="create()" class="btn-primary">
                    <x-svg.add size="h-6 w-6" />
                    <span>Evento</span>
                </button>
            </div>
            @endcan
        </div>

        <div class="flex flex-wrap m-0  rounded-md">

            @foreach ($dataAll as $data)
            <div class="w-full md:w-1/2 lg:w-1/3 xl:w-1/4 p-2">
                <div class="bg-gray-100  max-w-sm  dark:bg-slate-800 overflow-hidden shadow rounded-lg flex flex-col ">
                    <div class="flex-shrink-0">
                        <img src="{{ asset(!empty($data->image) ? $data->image : 'images/curso.png') }}"
                            alt="Logo Evento {{ $data->name }}"
                            class="hover:scale-110 h-52 w-full object-cover rounded-t-lg cursor-pointer"
                            wire:click="manager({{ $data->id }})">
                    </div>
                    <div class="flex-grow p-4 flex flex-col justify-between">
                        <div class="mb-4">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ $data->name }}</h3>
                            <p class="text-sm text-gray-500 dark:text-white">{{ getTypeEvent($data->type) }}</p>
                            <p class="text-sm text-gray-500 dark:text-white">{{ getStatusEvent($data->status) }}</p>
                        </div>
                        <div>
                            <hr class="my-2 border-gray-300">
                            <div class="flex justify-between px-5 ">
                                <button wire:click.prevent="manager({{ $data->id }})" class="hover:scale-125">
                                    <x-svg.view size="h-9 w-9 text-gray-400" />
                                </button>
                                <button wire:click.prevent="edit({{ $data->id }})" class="hover:scale-125">
                                    <x-svg.edit size="h-6 w-6 " />
                                </button>
                                <button wire:click.prevent="delete({{ $data->id }})" class="hover:scale-125">
                                    <x-svg.delete />
                                </button>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

            @endforeach
        </div>

        <div class="mt-4">
            {{ $dataAll->links() }}
        </div>
    </div>
    @if ($isOpen)
    @include('livewire.event.create')
    @endif
</div>
