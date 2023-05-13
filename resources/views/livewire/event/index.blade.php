<div>
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
        @if (session()->has('message'))
            <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3" role="alert">
                <div class="flex">
                <div>
                    <p class="text-sm">{{ session('message') }}</p>
                </div>
                </div>
            </div>
        @endif
        <h1 class="float-left py-4 font-bold text-xl">Lista de Eventos</h1>
        <button wire:click="create()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded my-3 float-right">Novo Evento</button>
        @if($isOpen)
            @include('livewire.event.create')
        @endif
        <table class="table-fixed w-full">
            <thead>
                <tr class="bg-gray-100">
                    <th class="text-left px-2 w-32">Tipo</th>
                    <th class="text-left px-2">Nome</th>
                    <th class="text-left px-2">Status</th>
                    <th class="text-left px-2 w-48"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($dataAll as $data)
                <tr>
                    <td class="border px-2 py-2">{{ getTypeEvent($data->type) }}</td>
                    <td class="border px-2 py-2">{{ $data->name }}</td>
                    <td class="border px-2 py-2">{{ getStatusEvent($data->status) }}</td>
                    <td class="border px-2 py-2">
                        <button wire:click="edit({{ $data->id }})" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Edit</button>
                        <button wire:click="delete({{ $data->id }})" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Delete</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
