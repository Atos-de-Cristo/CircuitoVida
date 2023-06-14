<div>
    @if (session()->has('message'))
        <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3"
            role="alert" x-data="{ showMessage: true }" x-show="showMessage" x-init="setTimeout(() => { showMessage = false; }, 4000)">
            <div class="flex">
                <div>
                    <p class="text-sm">{{ session('message') }}</p>
                </div>
            </div>
        </div>
    @endif
    <div class="flex flex-col md:flex-row items-center justify-between mb-2">
        <div class="flex items-center mb-2 md:mb-0">

        </div>
        <div class=" hidden md:inline">
            <ol class="flex items-center space-x-2  text-sm">
                <li class="breadcrumb-item">
                    <a href="{{ url()->previous() }}" class="text-blue-500 hover:underline">Voltar</a>
                </li>
                <span class="text-gray-500">/</span>
                <li class="breadcrumb-item active">Questões</li>
            </ol>
        </div>
    </div>

    @can('admin')
    <form class="">
        <div class="bg-white dark:bg-slate-800 shadow-xl rounded-md">
            <div class="bg-gray-50 dark:bg-gray-700 text-center rounded">
                <h2 class="text-lg text-gray-800 dark:text-white font-bold p-2 mb-4">Adicionar Questões</h2>
            </div>
            <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">

                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300  text-sm font-bold mb-2">Tipo:</label>
                    <div class="flex items-center">
                        <label class="mr-4">
                            <input wire:model="type" type="radio" value="aberta" class="mr-1">
                            <span class="text-sm">Aberto</span>
                        </label>
                        <label>
                            <input wire:model="type" type="radio" value="multi" class="mr-1">
                            <span class="text-sm">Múltipla Escolha</span>
                        </label>
                        @error('type')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label for="title" class="block text-gray-700 dark:text-gray-300  text-sm font-bold mb-2">Título:</label>
                    <input wire:model.lazy="title" type="text" id="title" name="title"
                        class="shadow appearance-none border border-gray-300 rounded w-full  py-2 px-3  text-gray-700 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 leading-tight focus:outline-none focus:shadow-outline">
                    @error('title')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                @if ($type === 'multi')
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300  text-sm font-bold mb-2">Opções:</label>
                        @if (!is_null($options))
                            @foreach ($options as $index => $option)
                                <div class="flex items-center mb-2">
                                    <input wire:model.lazy="options.{{ $index }}.text" type="text"
                                        class="w-full px-4 py-2 border border-gray-300 rounded  text-gray-700 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300rounded">
                                    <label class="ml-2">
                                        <input wire:model="options.{{ $index }}.correct" type="checkbox"
                                            class="mr-1 border-gray-400">
                                        <span class="text-sm">Correta</span>
                                    </label>
                                    <button type="button" wire:click="removeOption({{ $index }})"
                                        class="ml-2 px-4 py-2 bg-red-500 text-white rounded">Remover</button>
                                </div>
                                @error("options.{$index}.text")
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            @endforeach
                        @endif
                        <button type="button" wire:click="addOption"
                            class="px-4 py-2 bg-green-500 text-white rounded">Adicionar Opção</button>
                    </div>
                @endif

            </div>

            <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 rounded-md sm:px-6 sm:flex sm:flex-row-reverse mb-4">
                <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                    <button wire:click.prevent="store()" type="button"
                        class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                        Salvar
                    </button>
                </span>
            </div>
        </div>

    </form>
@endcan

<div class="grid grid-cols-12 gap-4">
    <div class="{{ auth()->check() && auth()->user()->hasPermissionTo('user') ? 'col-span-12' : 'col-span-8' }}">
        <form class="">
            <div class="bg-white dark:bg-slate-800 shadow-xl rounded-md ">
                <div class="bg-gray-50 dark:bg-gray-700 text-center rounded-md">
                    <h2 class="text-lg text-gray-800 dark:text-white font-bold p-2 mb-4">Responder Questões</h2>
                </div>
                <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    @forelse ($questions as $question)
                        <div
                            class="mb-4 border border-gray-300  dark:border-gray-700 rounded-md p-4
                            {{ $question->response_status == 'correto' ? 'bg-green-100 border-green-300' : '' }}
                            {{ $question->response_status == 'errado' ? 'bg-red-100 border-red-300' : '' }}
                            {{ $question->response_status == 'pendente' ? 'bg-gray-100 border-gray-300 dark:border-gray-700 dark:bg-gray-900' : '' }}">
                            <div class="flex flex-row justify-between">
                                <h3 class="text-lg font-semibold mb-2">{{ $question->title }}</h3>
                                @can('admin')
                                    <div class="flex flex-row">
                                        <button wire:click.prevent="edit({{ $question->id }})" class="mr-2">
                                            <x-svg.edit/>

                                        </button>
                                        <button wire:click.prevent="dell({{ $question->id }})">
                                            <x-svg.delete/>
                                        </button>
                                    </div>
                                @endcan
                            </div>
                            @if ($question->type === 'aberta')
                                @if ($question->response)
                                    {{ $question->response }}
                                @else
                                    <input type="text" wire:model.lazy="answers.{{ $question->id }}"
                                        class="w-full px-4 py-2 border border-gray-300 text-gray-700 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 rounded" placeholder="Sua resposta">
                                    @error("answers.{$question->id}")
                                        <span class="text-red-500">{{ $message }}</span>
                                    @enderror
                                @endif
                            @elseif ($question->type === 'multi')
                                @if ($question->response)
                                    {{ $question->response }}
                                @else
                                    @forelse (json_decode($question->options) as $index => $option)
                                        <label class="flex items-center">
                                            <input type="radio" name="question_{{ $question->id }}"
                                                wire:model="answers.{{ $question->id }}" value="{{ $option->text }}"
                                                class="mr-2" {{ $question->response == $option->text ? 'checked' : '' }}>
                                            <span class="text-sm">{{ $option->text }}</span>
                                        </label>
                                        @error("answers.{$question->id}")
                                            <span class="text-red-500">{{ $message }}</span>
                                        @enderror

                                    @empty
                                        <span class="text-red-500">Nenhuma opção cadastrada</span>
                                    @endforelse
                                @endif
                            @endif
                        </div>
                    @empty
                        <span class="text-red-500">Nenhuma questão cadastrada</span>
                    @endforelse
                </div>
                <div class="bg-gray-50 dark:bg-gray-700 px-4 rounded py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                        <button type="button" wire:click.prevent="storeQuestion()"
                            {{ $checkResponse == true ? 'disabled' : '' }}
                            class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                            Salvar
                        </button>
                    </span>
                </div>
            </div>
        </form>
    </div>
    @can('admin')
    <div class="col-span-4">
        <div class="bg-white dark:bg-slate-800 shadow-xl rounded-md">
            <!-- Conteúdo do formulário -->
          Listar todos os users que responderam
        </div>
    </div>
    @endcan
</div>



