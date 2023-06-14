<div>
    @if (session()->has('message'))
    <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3"
         role="alert"
         x-data="{ showMessage: true }"
         x-show="showMessage"
         x-init="setTimeout(() => { showMessage = false; }, 4000)">
        <div class="flex">
            <div>
                <p class="text-sm">{{ session('message') }}</p>
            </div>
        </div>
    </div>
@endif
<div class="flex flex-col md:flex-row items-center justify-between mb-2">
    <div class="flex items-center mb-2 md:mb-0">
        <div class="ml-2 text-xl font-bold">
            Lista de Usuários
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

        <div class="font-bold  flex items-center">
            <div class="relative mr-4 flex ">
                <input wire:model.debounce.300ms="search" wire:ignore placeholder="Buscar usuário..."
                class="form-input peer h-full rounded-full bg-slate-150 px-4 pl-9 text-xs+ text-gray-700 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 ring-primary/50 hover:bg-slate-200 focus:ring dark:bg-navy-900/90 dark:text-navy-100 dark:placeholder-navy-300 dark:ring-accent/50 dark:hover:bg-navy-900 dark:focus:bg-navy-900 w-60"
                 type="text"
               >
            <x-svg.search/>
            </div>
        </div>

        @can('admin')
            <div class="mt-2 sm:mt-0 flex space-x-2">
                <button wire:click="create()" class="btn-primary">
              <x-svg.add size="h-6 w-6"/>
                    <span>Usuário</span>
                </button>
            </div>
        @endcan
    </div>


    <div class="flex flex-wrap m-0  rounded-md">
        @foreach ($dataAll as $data)
        <div class="w-full md:w-1/2 lg:w-1/2 xl:w-1/4 p-4">
            <div class="bg-gray-100 dark:bg-slate-600 overflow-hidden shadow rounded-lg flex flex-col h-full">
                <div class="flex-grow p-4 flex flex-col items-center justify-center">
                    <div class="w-16 h-16 rounded-full overflow-hidden">
                        @if ($data->profile_photo_url)
                            <img src="{{ asset($data->profile_photo_url) }}" alt="{{ $data->name }}"
                                class="object-cover h-full w-full cursor-pointer"
                                wire:click="manager({{ $data->id }})">
                        @else
                            <img src="{{ asset('images/curso.png') }}" alt="Logo"
                                class="bg-slate-500 object-cover h-full w-full cursor-pointer"
                                wire:click="manager({{ $data->id }})">
                        @endif
                    </div>
                </div>
                <div class="flex-grow p-4 flex flex-col justify-between">
                    <div class="mb-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ $data->name }}</h3>
                        <p class="text-sm text-gray-500 dark:text-white">{{ $data->email }}</p>
                        <p class="text-sm text-gray-500 dark:text-white">{{$data->permissions()->implode('permission', ',') }}</p>
                    </div>
                    <div>
                        <hr class="my-2 border-gray-300">
                        <div class="flex justify-center md:space-x-4 md:space-y-0 space-y-4 flex-col md:flex-row">
                            <button wire:click.prevent="manager({{ $data->id }})"
                                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded w-full">
                                Ver
                            </button>
                            <button wire:click.prevent="edit({{ $data->id }})"
                                class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded w-full">
                                Editar
                            </button>
                            <button wire:click.prevent="delete({{ $data->id }})"
                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded w-full">
                                Deletar
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
    @if($isOpen)
        @include('livewire.user.create')
    @endif
</div>

