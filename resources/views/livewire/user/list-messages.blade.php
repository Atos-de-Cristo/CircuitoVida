<div>
    <div class="flex flex-col md:flex-row items-center justify-between mb-2">
        <h1 class="float-left py-4 font-bold text-xl">Lista de Mensagens</h1>
    </div>
    <div class="card-white">
        <ul>
            @forelse ($this->listMessage as $message)
            <li class="flex flex-row justify-between mt-2">
                <div>
                    <svg class="w-6 h-6 text-black dark:text-white" viewBox="0 0 24 24" fill="none"
                        transform="rotate(0)matrix(-1, 0, 0, 1, 0, 0)">
                        <path  d="M8 8H16M8 12H13M7 16V21L12 16H20V4H4V16H7Z" stroke="currentColor" stroke-width="1.5"
                            stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>                
                    <p>{{$message->message}}</p>
                    <small>Enviado por: {{$message->userSend->name}}</small>
                    <small>{{\Carbon\Carbon::parse($message->date_send)->format('d/m/Y H:i:s')}}</small>
                </div>
                @if (!$message->read)
                <button wire:click.prevent="read({{$message->id}})">Marcar como Lida</button>
                @endif
            </li>
            <li class="border-b dark:border-gray-500"></li>
            @empty
            <li>
                <p>Nenhuma mensagem encontrada</p>
            </li>
            @endforelse
        </ul>
    </div>
</div>