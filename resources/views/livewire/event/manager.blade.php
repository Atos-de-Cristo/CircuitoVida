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
        <div class="flex justify-between">
            <div>
                <h1>{{$event->name}}</h1>
            </div>
            <div>
                <button wire:click="createModule()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Modulos</button>
                <button wire:click="createLesson()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Aulas</button>
            </div>
        </div>
        <div>
            <h1>Aulas</h1>
            <table class="table-fixed w-full">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="text-left px-2 w-40">#</th>
                        <th class="text-left px-2">Tema</th>
                        <th class="text-left px-2">Modulo</th>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($event->lessons as $item)
                    <tr>
                        <td class="border px-2 py-2">{{ $item->id }}</td>
                        <td class="border px-2 py-2">{{ $item->title }}</td>
                        <td class="border px-2 py-2">{{ $item->module->name }}</td>
                        <td class="border px-2 py-2">
                            <button wire:click="approveInscription({{ $item->id }})" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Frequencia
                            </button>
                            <button wire:click="approveInscription({{ $item->id }})" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Atividade
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div>
            <h1>Inscricoes</h1>
            <table class="table-fixed w-full">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="text-left px-2 w-40">#</th>
                        <th class="text-left px-2">Nome</th>
                        <th class="text-left px-2">Email</th>
                        <td class="text-left px-2">Status</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($event->inscriptions as $item)
                    <tr>
                        <td class="border px-2 py-2">{{ $item->user->id }}</td>
                        <td class="border px-2 py-2">{{ $item->user->name }}</td>
                        <td class="border px-2 py-2">{{ $item->user->email }}</td>
                        <td class="border px-2 py-2">{{ getStatusInscription($item->status) }}</td>
                        <td class="border px-2 py-2">
                            @if ($item->status == 'P')
                                <button wire:click="approveInscription({{ $item->id }})" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Aprovar</button>
                            @endif
                            @if ($item->status == 'L')
                                <button wire:click="disapproveInscription({{ $item->id }})" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Cancelar</button>
                            @endif
                            @if ($item->status == 'C')
                                <button wire:click="approveInscription({{ $item->id }})" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Aprovar</button>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @if ($isOpenModule)
        @include('livewire.event.module-create')
    @endif
    @if ($isOpenLesson)
        @include('livewire.event.lesson-create')
    @endif
</div>
