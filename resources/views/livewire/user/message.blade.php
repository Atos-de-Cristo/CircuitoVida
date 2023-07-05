<div>
    @if (session()->has('message'))
    <div
      x-data="{ showMessage: true }"
      x-show="showMessage"
      x-init="setTimeout(() => { showMessage = false; }, 1000)"
      class="bg-teal-100 border-teal-500 rounded-md text-teal-900 px-4 py-3 shadow-md my-3"
      role="alert"
    >
      <div class="flex">
        <div>
          <p class="text-sm">{{ session('message') }}</p>
        </div>
      </div>
    </div>
    @endif
    @can('admin')
    <form>
      <div
      x-data="{ textareaHeight: 'auto' }"
      x-init="() => {
        const textarea = document.getElementById('messageTextarea');
    
        increaseTextareaHeight = () => {
          textarea.style.height = 'auto';
          textarea.style.height = textarea.scrollHeight + 'px';
          textareaHeight = textarea.style.height;
        };
    
        decreaseTextareaHeight = () => {
          textarea.style.height = 'auto';
          textarea.style.height = textarea.scrollHeight - 16 + 'px';
          textareaHeight = textarea.style.height;
        };
    
        textarea.addEventListener('keydown', (event) => {
          if (event.key === 'Enter' && !event.shiftKey) {
            event.preventDefault();
            increaseTextareaHeight();
            textarea.value += '\n';
            textarea.scrollTop = textarea.scrollHeight;
          }
          if (event.key === 'Backspace') {
            decreaseTextareaHeight();
          }
        });
      }"
        class="flex flex-col w-full py-[10px] flex-grow md:py-4 md:pl-4 relative border border-gray-300 text-gray-700 dark:border-gray-600 dark:text-gray-300  dark:bg-gray-800 rounded-xl shadow-xs dark:shadow-xs"
      >
        <textarea
          id="messageTextarea"
          wire:model="message"
          rows="2"
          placeholder="Enviar uma mensagem"
          class="m-0 w-full resize-none border-0 bg-transparent p-0 pr-10 focus:ring-0 focus-visible:ring-0 dark:bg-transparent md:pr-12 pl-3 md:pl-0"
          x-bind:style="{ height: textareaHeight }"
          style="overflow-y: auto; scrollbar-width: thin; scrollbar-color: transparent transparent; resize: vertical;"
        ></textarea>
        <button
          wire:click="send"
          
          {{$message == null||$message == '' ? 'disabled' : ''}}
          class="absolute p-1 rounded-md md:bottom-3 md:p-2 md:right-3 enabled:bg-green-600 dark:disabled:hover:bg-transparent right-2 disabled:text-gray-400  enabled:bg-green-purple text-white bottom-1.5 transition-colors disabled:opacity-10"
        >
          <span class="" data-state="closed">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="none" class="h-4 w-4 m-1 md:m-0" stroke-width="2">
              <path d="M.5 1.163A1 1 0 0 1 1.97.28l12.868 6.837a1 1 0 0 1 0 1.766L1.969 15.72A1 1 0 0 1 .5 14.836V10.33a1 1 0 0 1 .816-.983L8.5 8 1.316 6.653A1 1 0 0 1 .5 5.67V1.163Z" fill="currentColor"></path>
            </svg>
          </span>
        </button>
      </div>
    </form>
    @endcan
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
  