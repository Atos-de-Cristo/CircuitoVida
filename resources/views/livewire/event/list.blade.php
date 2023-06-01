<div>
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
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

        <div class="flex flex-col sm:flex-row justify-between items-center mb-4">
            <h1 class="text-2xl font-bold mb-2 sm:mb-0">Lista de Eventos</h1>
            <button wire:click="create()"
                class="inline-flex items-center justify-center bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-full">
                <span >Novo Evento</span>

            </button>
        </div>
        <div class="mb-4">
            <input wire:model.debounce.300ms="search" type="text"
                class="w-full sm:w-64 border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring focus:border-blue-500"
                placeholder="Buscar usuários...">
        </div>

        <div class="flex flex-wrap -m-4">
            @foreach ($dataAll as $data)
                <div class="w-full md:w-1/2 lg:w-1/3 xl:w-1/4 p-4">
                    <div class="bg-white overflow-hidden shadow rounded-lg flex flex-col h-full">
                        <div class="flex-shrink-0">
                            @if ($data->image)
                                <img src="{{ asset($data->image) }}" alt="Logo Evento {{ $data->name }}"
                                    class="hover:scale-125 h-52 w-full object-cover rounded-t-lg cursor-pointer"
                                    wire:click="manager({{ $data->id }})">
                            @else
                                <img src="{{ asset('images/curso.png') }}" alt="Logo"
                                    class="hover:scale-125 h-52 w-full bg-slate-500 rounded-t-lg cursor-pointer"
                                    wire:click="manager({{ $data->id }})">
                            @endif
                        </div>
                        <div class="flex-grow p-4 flex flex-col justify-between">
                            <div class="mb-4">
                                <h3 class="text-lg font-medium text-gray-900">{{$data->name}}</h3>
                                <p class="text-sm text-gray-500">{{getTypeEvent($data->type)  }}</p>
                                <p class="text-sm text-gray-500">{{ getStatusEvent($data->status) }}</p>
                            </div>
                            <div>
                                <hr class="my-2 border-gray-300">
                                <div class="flex justify-center space-x-4">

                                    <button wire:click="manager({{ $data->id }})"
                                        class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded w-full ">
                                        View
                                    </button>

                                    <button wire:click="edit({{ $data->id }})"
                                        class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded w-full">
                                        Edit
                                    </button>
                                    <button wire:click="delete({{ $data->id }})"
                                        class="bg-red-500 hover:bg-red-700 text-white  font-bold py-2 px-4 rounded w-full">
                                        Delete
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

