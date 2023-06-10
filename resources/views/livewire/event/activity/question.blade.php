<div>
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
    @can('admin')
        <form class="">
            <div class="bg-white shadow-xl rounded-md">
                <div class="bg-gray-50 text-center rounded-md">
                    <h2 class="text-lg text-gray-800 font-bold p-2 mb-4">Adicionar Questões</h2>
                </div>
                <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">

                    <div class="mb-4">
                        <label class="block">Tipo:</label>
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
                        <label for="title" class="block">Título:</label>
                        <input wire:model="title" type="text" id="title" name="title"
                            class="w-full px-4 py-2 border border-gray-300 rounded">
                        @error('title')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    @if ($type === 'multi')
                        <div class="mb-4">
                            <label class="block">Opções:</label>
                            @if (!is_null($options))
                                @foreach ($options as $index => $option)
                                    <div class="flex items-center mb-2">
                                        <input wire:model="options.{{ $index }}.text" type="text"
                                            class="w-full px-4 py-2 border border-gray-300 rounded">
                                        <label class="ml-2">
                                            <input wire:model="options.{{ $index }}.correct" type="checkbox"
                                                class="mr-1">
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

            <div class="bg-gray-50 px-4 py-3 rounded-md sm:px-6 sm:flex sm:flex-row-reverse mb-4">
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
    <form class="">

        <div class="bg-white shadow-xl  rounded-md ">
            <div class="bg-gray-50 text-center rounded-md">
                <h2 class="text-lg text-gray-800 font-bold p-2 mb-4">Responder Questões</h2>
            </div>
            <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                @forelse ($questions as $question)
                <div class="mb-4 bg-gray-100 border border-gray-300  rounded-md p-4">
                    <div class="flex flex-row justify-between">
                        <h3 class="text-lg font-semibold mb-2">{{ $question->title }}</h3>
                        <div class="flex flex-row">
                            <button wire:click.prevent="edit({{$question->id}})" class="mr-2">
                                <img src="{{ asset('svg/edit.svg') }}" alt="Ícone">
                            </button>
                            <button wire:click.prevent="dell({{$question->id}})">
                                <img src="{{ asset('svg/delete.svg') }}" alt="Ícone">
                            </button>
                        </div>
                    </div>
                    @if ($question->type === 'aberta')
                        <input
                            type="text"
                            wire:model="answers.{{ $question->id }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded"
                            placeholder="Sua resposta"
                        >
                        @error("answers.{$question->id}")
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    @elseif ($question->type === 'multi')
                        @if (!is_null($question->options))
                            @foreach (json_decode($question->options) as $index => $option)
                                <label class="flex items-center">
                                    <input type="radio" name="question_{{ $question->id }}" wire:model="answers.{{ $question->id }}"
                                        value="{{ $option->text }}" class="mr-2">
                                    <span class="text-sm">{{ $option->text }}</span>
                                </label>
                                @error("answers.{$question->id}")
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            @endforeach
                        @endif
                    @endif
                </div>
                @empty
                    <span class="text-red-500">Nenhuma questão cadastrada</span>
                @endforelse
            </div>
            <div class="bg-gray-50 px-4 rounded-md py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                    <button
                        type="button"
                        wire:click.prevent="storeQuestion()"
                        class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5"
                    >
                        Salvar
                    </button>
                </span>
            </div>
        </div>
    </form>
</div>
