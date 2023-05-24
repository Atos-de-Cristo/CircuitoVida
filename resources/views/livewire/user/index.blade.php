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
            <h1 class="text-xl font-bold mb-4 sm:mb-0">Lista de Usuários</h1>
            <button wire:click="create()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Novo usuário</button>
        </div>
        <div class="mb-4">
            <input wire:model.debounce.300ms="search" type="text" class="w-full sm:w-64 border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring focus:border-blue-500" placeholder="Buscar usuários...">
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr class="bg-gray-100">

                        <th wire:click="sortBy('id')" class="px-4 py-2 w-16">
                            #
                            @if ($sortBy === 'id')
                                @if ($sortDirection === 'asc')
                                    &#9650;
                                @else
                                    &#9660;
                                @endif
                            @endif
                        </th>
                        <th wire:click="sortBy('name')" class="px-4 py-2 ">
                            Nome
                            @if ($sortBy === 'name')
                                @if ($sortDirection === 'asc')
                                    &#9650;
                                @else
                                    &#9660;
                                @endif
                            @endif
                        </th>
                        <th wire:click="sortBy('email')" class="px-4 py-2 ">
                            Email
                            @if ($sortBy === 'email')
                                @if ($sortDirection === 'asc')
                                    &#9650;
                                @else
                                    &#9660;
                                @endif
                            @endif
                        </th>
                        <th wire:click="sortBy('tipo')" class=" px-4 py-2 ">
                            Tipo
                            @if ($sortBy === 'tipo')
                                @if ($sortDirection === 'asc')
                                    &#9650;
                                @else
                                    &#9660;
                                @endif
                            @endif
                        </th>

                        <th class="px-4 py-2 w-48"></th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($dataAll as $data)
                        <tr>
                            <td class="border px-4 py-2 ">{{ $data->id }}</td>
                            <td class="border px-4 py-2">{{ $data->name }}</td>
                            <td class="border px-4 py-2">{{ $data->email }}</td>
                            <td class="border px-4 py-2">{{ $data->permissions()->implode('permission', ',') }}</td>
                            <td class="border px-4 py-2">
                                <button wire:click="edit({{ $data->id }})" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Edit</button>
                                <button wire:click="delete({{ $data->id }})" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Delete</button>
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
    @if($isOpen)
        @include('livewire.user.create')
    @endif
</div>

