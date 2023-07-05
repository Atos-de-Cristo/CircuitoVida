<div>
    @if (session()->has('message'))
        <div class="bg-teal-100  border-teal-500 rounded-md text-teal-900 px-4 py-3 shadow-md my-3" role="alert"
            x-data="{ showMessage: true }" x-show="showMessage" x-init="setTimeout(() => { showMessage = false; }, 1000)">
            <div class="flex">
                <div>
                    <p class="text-sm">{{ session('message') }}</p>
                </div>
            </div>
        </div>
    @endif
    @can('admin')
        <form>
            <div class="">
                <label for="campMessage" class="label-input-form">Enviar mensagem:</label>
                <textarea
                    class="input-form w-full"
                    id="campMessage"
                    wire:model.defer="message"
                    placeholder="Qual mensagem deseja enviar?"
                    rows="5"
                    required
                ></textarea>
                @error('message')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
                <button wire:click.prevent='send'>Enviar</button>
            </div>
        </form>
    @endcan
    <ul>
        @forelse ($this->listMessage as $message)
            <li class="flex flex-row justify-between mt-2">
                <div>
                    <small>Enviado por: {{$message->userSend->name}}</small>
                    <p>{{$message->message}}</p>
                    <small>{{\Carbon\Carbon::parse($message->date_send)->format('d/m/Y H:m:s')}}</small>
                </div>
                @if (!$message->read)
                    <button wire:click.prevent="read({{$message->id}})">Marcar como Lida</button>
                @endif
            </li>
        @empty
            <li>
                <p>Nenhuma mensagem encontrada</p>
            </li>
        @endforelse
    </ul>
</div>
