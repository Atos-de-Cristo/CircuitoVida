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
    <ul class="py-4">
      @forelse ($this->listMessage as $message)
      <li class="flex items-start mb-2">
        <div>
            <img class="w-12 h-12 bg-black rounded-full mr-2" src="{{ asset($message->userSend->profile_photo_url) }}"
                width="32" height="32" alt="{{ $message->userSend->name }}" />
        </div>
        <div
            class="flex-1 rounded-lg rounded-tl-none overflow-hidden shadow-lg bg-white dark:bg-gray-800 mr-14">
            <div class="px-4 py-2 flex flex-col sm:flex-row justify-between">
                <p>{{$message->message}}</p>
                <div>
                    @if ($message->user_for == auth()->user()->id)
                        @if (!$message->read)
                            <button wire:click.prevent="read({{$message->id}})">
                                <svg class="h-5 w-5 animate-pulse hover:animate-none" viewBox="0 0 24 24"
                                    fill="none">
                                    <path opacity="0.5"
                                        d="M22 10C22.0185 10.7271 22 11.0542 22 12C22 15.7712 22 17.6569 20.8284 18.8284C19.6569 20 17.7712 20 14 20H10C6.22876 20 4.34315 20 3.17157 18.8284C2 17.6569 2 15.7712 2 12C2 8.22876 2 6.34315 3.17157 5.17157C4.34315 4 6.22876 4 10 4H13"
                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                                    <path
                                        d="M6 8L8.1589 9.79908C9.99553 11.3296 10.9139 12.0949 12 12.0949C13.0861 12.0949 14.0045 11.3296 15.8411 9.79908"
                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                                    <circle cx="19" cy="5" r="3" stroke="currentColor" stroke-width="1.5"></circle>
                                </svg>
                            </button>
                        @endif
                        <button wire:click.prevent="sendMessage({{$message->user_send}})">
                            Responder!
                        </button>
                    @endif
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 px-4 py-2">
                <div class="flex flex-col sm:flex-row justify-between">
                    <div>
                        <small class="font-sans">{{$message->userSend->name}}</small>
                    </div>
                    <div class="sm:ml-4">
                        <small class="sm:block italic">Publicado
                            <span>{{\Carbon\Carbon::parse($message->created_at)->format('d/m/Y H:m:s')}}</span>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </li>
      @empty
      <li>
        <p>Nenhuma mensagem encontrada</p>
      </li>
      @endforelse
    </ul>
  </div>
