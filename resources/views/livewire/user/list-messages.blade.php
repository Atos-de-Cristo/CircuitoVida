<div>
    <div class="flex flex-col md:flex-row items-center justify-between mb-2">
        <h1 class="float-left py-4 font-bold text-xl">Lista de Mensagens</h1>
    </div>
    <div class="card-white">
        <ul>
            @forelse ($this->listMessage as $message)
                <li class="flex flex-row justify-between mt-2">
                    <div>
                        <small>Enviado por: {{$message->userSend->name}}</small>
                        <p>{{$message->message}}</p>
                        <small>{{\Carbon\Carbon::parse($message->date_send)->format('d/m/Y H:i:s')}}</small>
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
</div>
