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
<h1 class="text-xl font-bold mb-4 sm:mb-0">Lista de Usuários</h1>
<div class="card-white">
    <div class="flex flex-col mb-4 sm:flex-row justify-between items-center">

        <div class="font-bold  flex items-center">
            <div class="relative mr-4 flex ">
                <input wire:model.debounce.300ms="search" wire:ignore placeholder="Buscar usuário..."
                class="form-input peer h-full rounded-full bg-slate-150 px-4 pl-9 text-xs+ text-slate-800 ring-primary/50 hover:bg-slate-200 focus:ring dark:bg-navy-900/90 dark:text-navy-100 dark:placeholder-navy-300 dark:ring-accent/50 dark:hover:bg-navy-900 dark:focus:bg-navy-900 w-60"
                 type="text"
               >
                <div
                    class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-colors duration-200"
                        fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M3.316 13.781l.73-.171-.73.171zm0-5.457l.73.171-.73-.171zm15.473 0l.73-.171-.73.171zm0 5.457l.73.171-.73-.171zm-5.008 5.008l-.171-.73.171.73zm-5.457 0l-.171.73.171-.73zm0-15.473l-.171-.73.171.73zm5.457 0l.171-.73-.171.73zM20.47 21.53a.75.75 0 101.06-1.06l-1.06 1.06zM4.046 13.61a11.198 11.198 0 010-5.115l-1.46-.342a12.698 12.698 0 000 5.8l1.46-.343zm14.013-5.115a11.196 11.196 0 010 5.115l1.46.342a12.698 12.698 0 000-5.8l-1.46.343zm-4.45 9.564a11.196 11.196 0 01-5.114 0l-.342 1.46c1.907.448 3.892.448 5.8 0l-.343-1.46zM8.496 4.046a11.198 11.198 0 015.115 0l.342-1.46a12.698 12.698 0 00-5.8 0l.343 1.46zm0 14.013a5.97 5.97 0 01-4.45-4.45l-1.46.343a7.47 7.47 0 005.568 5.568l.342-1.46zm5.457 1.46a7.47 7.47 0 005.568-5.567l-1.46-.342a5.97 5.97 0 01-4.45 4.45l.342 1.46zM13.61 4.046a5.97 5.97 0 014.45 4.45l1.46-.343a7.47 7.47 0 00-5.568-5.567l-.342 1.46zm-5.457-1.46a7.47 7.47 0 00-5.567 5.567l1.46.342a5.97 5.97 0 014.45-4.45l-.343-1.46zm8.652 15.28l3.665 3.664 1.06-1.06-3.665-3.665-1.06 1.06z">
                        </path>
                    </svg>
                </div>
            </div>
        </div>

        @can('admin')
            <div class="mt-2 sm:mt-0 flex space-x-2">
                <button wire:click="create()" class="btn-primary">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 5v14M5 12h14" />
                    </svg>
                    <span>Usuário</span>
                </button>
            </div>
        @endcan
    </div>

    <div class="flex flex-wrap m-0 bg-gray-50 rounded">
        @foreach ($dataAll as $data)
        <div class="w-full md:w-1/2 lg:w-1/3 xl:w-1/4 p-4">
            <div class="bg-white overflow-hidden shadow rounded-lg flex flex-col h-full">
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
                        <h3 class="text-lg font-medium text-gray-900">{{ $data->name }}</h3>
                        <p class="text-sm text-gray-500">{{ $data->email }}</p>
                        <p class="text-sm text-gray-500">{{$data->permissions()->implode('permission', ',') }}</p>
                    </div>
                    <div>
                        <hr class="my-2 border-gray-300">
                        <div class="flex justify-center space-x-4">
                            <a href="{{ route('userDetails', ['id' => $data->id]) }}"
                                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded w-full">Ver</a>
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

