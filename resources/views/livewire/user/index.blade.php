<div>
    @if (session()->has('message'))
    <x-alert-message :message="session('message')['text']" :messageType="session('message')['type']" />
    @endif
    <div class="flex flex-col md:flex-row items-start justify-between mb-2">
        <div class="flex items-center mb-2 md:mb-0">
            <div class="ml-2 text-xl font-bold">
                Lista de Usuários
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
            <x-search-form placeholder="Buscar usuário..."/>
            <div class="mt-2 sm:mt-0 flex space-x-2">

                @can('admin')
                @include('livewire.user.create')
                @endcan
            </div>
        </x-slot>

        <x-slot name="contentCard">
            @foreach ($dataAll as $data)
            <div class="w-full md:w-1/2 lg:w-1/2 xl:w-1/4 p-4">
                <div class="bg-gray-100 dark:bg-slate-800 overflow-hidden shadow rounded-lg flex flex-col h-full">
                    <div class="flex-grow p-4 flex flex-col items-center justify-center">
                        <div class="w-16 h-16 rounded-full overflow-hidden">
                            @if ($data->profile_photo_url)
                            <img src="{{ asset($data->profile_photo_url) }}" alt="{{ $data->name }}"
                                class="object-cover h-full w-full cursor-pointer" wire:click="manager({{ $data->id }})">
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
                            <p class="text-sm text-gray-500 dark:text-white">
                                {{$data->permissions()->implode('permission', ',') }}</p>
                        </div>
                        <div>

                            <div class="dark:bg-slate-900 bg-slate-200 rounded-md py-3">
                                <div class="flex justify-between px-5 ">
                                    <button wire:click.prevent="manager({{ $data->id }})" class="hover:scale-125">
                                        <x-icon-eye class="w-6 h-6" />
                                    </button>
                                    <button wire:click.prevent="edit({{ $data->id }})" class="hover:scale-125">
                                        <x-icon-pencil class="w-5 h-5" />
                                    </button>
                                    <button wire:click.prevent="delete({{ $data->id }})" class="hover:scale-125">
                                        <x-icon-trash class="w-5 h-5" />
                                    </button>
                                </div>

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
</div>
