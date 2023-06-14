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
        <h1 class="float-left py-4 font-bold text-xl">Lista de Inscrições</h1>
        <table class="table-fixed w-full">
            <thead>
                <tr class="bg-gray-100">
                    <th class="text-left px-2 w-8"># </th>
                    <th>Imagem</th>
                    <th class="text-left px-2 w-32">Tipo</th>
                    <th class="text-left px-2">Nome a</th>
                    <th class="text-left px-2">Status</th>
                    <th class="text-left px-2"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($dataAll as $data)
                <tr>
                    <td class="border px-2 py-2">{{$data->id}}</td>
                    <td class="border">
                        @isset($data->event->image)
                            <img src="{{asset($data->event->image)}}" alt="Logo Evento {{$data->event->name}}">
                        @endisset
                    </td>
                    <td class="border px-2 py-2">{{ getTypeEvent($data->event->type) }}</td>
                    <td class="border px-2 py-2">{{ $data->event->name }}</td>
                    <td class="border px-2 py-2">{{getStatusInscription($data->status)}}</td>
                    <td class="border px-2 py-2">
                        <button wire:click="view({{ $data->event->id }})" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Ver</button>
                        <button wire:click="cancel({{ $data->id }})" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Cancelar</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
