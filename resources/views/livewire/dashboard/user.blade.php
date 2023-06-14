<div class="p-5">
    <h1 class="text-3xl font-bold text-gray-900 dark:text-black ">Cursos</h1>
    <div class="flex flex-wrap gap-4 sm:flex-row lg:flex-row mt-4">
        @forelse ($eventAll as $item)
            <div
                class="max-w-xs w-full sm:w-auto bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                @if ($item->image)
                    <a href="#">
                        <img class="rounded-t-lg object-contain  w-full h-48 sm:h-64" src="{{ $item->image }}"
                            alt="" />
                    </a>
                @else
                    <a href="#">
                        <img class="rounded-t-lg object-contain  w-full h-48 sm:h-64"
                            src="{{ asset('images/logo.png') }}" alt="" />
                    </a>
                @endif
                <div class="p-3">
                    <a href="#">
                        <h5 class="mb-2 text-xl font-semibold tracking-tight text-gray-900 dark:text-white">
                            {{ $item->name }}</h5>
                    </a>

                    @if ($item->inscriptions->firstWhere('user_id', Auth::user()->id))
                        <button  wire:click="view({{ $item->id }})"
                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Acessar!
                            <svg aria-hidden="true" class="w-4 h-4 ml-2 -mr-1" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    @else
                        <button wire:click="insc({{ $item->id }})"
                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Inscreva-se
                            <svg aria-hidden="true" class="w-4 h-4 ml-2 -mr-1" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    @endif
                </div>
            </div>
        @empty
            <p class="text-gray-600 dark:text-gray-400">Nenhum evento encontrado!</p>
        @endforelse
    </div>




</div>
