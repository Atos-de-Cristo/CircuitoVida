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
        <h1 class="float-left py-4 font-bold text-xl">Gerenciar Inscrições</h1>
        <table class="table-fixed w-full">
            <thead>
                <tr class="bg-gray-100">
                    <th class="text-left px-2 w-40">Imagem</th>
                    <th class="text-left px-2">Nome</th>
                    <th class="text-left px-2">Inicio</th>
                    <th class="text-left px-2">Fim</th>
                    <th class="text-left px-2">Status</th>
                    <th class="text-left px-2">Vagas</th>
                    <th class="text-left px-2">Inscritos</th>
                    <th class="text-left px-2">Valor</th>
                    <th class="text-left px-2"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($dataAll as $data)
                <tr>
                    <td class="border px-2 py-2">
                        @isset($data->image)
                            <img
                                src="{{asset($data->image)}}"
                                alt="Logo Evento {{$data->name}}"
                                class="hover:scale-125 transition-all duration-500 cursor-pointer"
                            >
                        @endisset
                    </td>
                    <td class="border px-2 py-2">
                        {{ $data->name }}<br />
                        Tipo: {{ getTypeEvent($data->type) }}
                    </td>
                    <td class="border px-2 py-2">{{ date('d/m/Y', strtotime($data->start_date)) }}</td>
                    <td class="border px-2 py-2">{{ date('d/m/Y', strtotime($data->end_date)) }}</td>
                    <td class="border px-2 py-2">{{ getStatusEvent($data->status) }}</td>
                    <td class="border px-2 py-2">{{ $data->tickets_limit }}</td>
                    <td class="border px-2 py-2">{{ count($data->inscriptions) }}</td>
                    <td class="border px-2 py-2">R$ {{ number_format(floatval($data->value), 2, ",", ".") }}</td>

                    <td class="border px-2 py-2">
                        {{-- TODO: usar enums --}}
                        @if ($data->status == 'P')
                            <button wire:click="open({{ $data->id }})" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Abrir Inscrições</button>
                        @endif
                        @if ($data->status == 'A')
                            <button wire:click="close({{ $data->id }})" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Encerrar</button>
                        @endif
                        @if ($data->status == 'E')
                            <button wire:click="viewInsc({{ $data->id }})" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Exibir Inscritos</button>
                            <button wire:click="open({{ $data->id }})" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Reabrir Inscrições</button>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @if($isUser)
        @include('livewire.event.inscription-user')
    @endif
</div>
