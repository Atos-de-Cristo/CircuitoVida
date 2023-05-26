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
            <h1 class="text-xl font-bold mb-4 sm:mb-0">Lista de Eventos</h1>
            <button wire:click="create()"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Novo Evento</button>
        </div>
        <div class="mb-4">
            <input wire:model.debounce.300ms="search" type="text"
                class="w-full sm:w-64 border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring focus:border-blue-500"
                placeholder="Buscar usuários...">
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 ">Imagem</th>
                        <th class="text-left px-2">Tipo</th>
                        <th class="text-left px-2">Nome</th>
                        <th class="text-left px-2">Status</th>
                        <th class="px-4 py-2 w-48"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dataAll as $data)
                        <tr>
                            <td class="border px-2 py-2 flex items-center justify-center">
                                @if ($data->image)
                                    <img src="{{ asset($data->image) }}" alt="Logo Evento {{ $data->name }}"
                                        class="hover:scale-125 w-48 object-contain rounded-lg cursor-pointer">
                                @else
                                    <img src="{{ asset('images/logo.png') }}" alt="Logo"
                                        class=" hover:scale-125 w-48  bg-slate-500 rounded-lg cursor-pointer">
                                @endif
                            </td>
                            <td class="border px-2 py-2">{{ getTypeEvent($data->type) }}</td>
                            <td class="border px-2 py-2">{{ $data->name }}</td>
                            <td class="border px-2 py-2">{{ getStatusEvent($data->status) }}</td>
                            <td class="border px-2 py-2">
                                <button
                                    wire:click="manager({{ $data->id }})"
                                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded"
                                >Gerenciar</button>
                                <button
                                    wire:click="edit({{ $data->id }})"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                                >Edit</button>
                                <button
                                    wire:click="delete({{ $data->id }})"
                                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                                >Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $dataAll->links() }}
        </div>
    </div>
    @if ($isOpen)
        @include('livewire.event.create')
    @endif
</div>
