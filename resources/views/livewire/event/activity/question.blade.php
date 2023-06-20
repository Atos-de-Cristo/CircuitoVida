<div>
    @if (session()->has('message'))
    <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3" role="alert"
        x-data="{ showMessage: true }" x-show="showMessage" x-init="setTimeout(() => { showMessage = false; }, 4000)">
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
                    <label class="label-input-form">Tipo:</label>
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
                    <label for="title" class="label-input-form">Título:</label>
                    <textarea wire:model.lazy="title" id="title" name="title" class="input-form"></textarea>
                    @error('title')
                    <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>


                @if ($type === 'multi')
                <div class="mb-4">
                    <label class="label-input-form">Opções:</label>
                    @if (!is_null($options))
                    @foreach ($options as $index => $option)
                    <div class="flex items-center mb-2">
                        <input wire:model.lazy="options.{{ $index }}.text" type="text" class="input-form">
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
                    <button wire:click.prevent="store()" type="button" class="btn-submit">
                        Salvar
                    </button>
                </span>
            </div>
        </div>

    </form>
    @endcan
    {{--Questões--}}
    <div class="grid grid-cols-12 gap-4">
        <div class="{{ auth()->check() && auth()->user()->hasPermissionTo('aluno') ? 'col-span-12' : 'col-span-8' }}">
            @if ($viewCorrectAnswers)
            <livewire:event-activity-question-correct :userId="$userCorrectAnswer" :atvId="$atvId" />
            @else
            <form class="">
                <div class="bg-white dark:bg-slate-800 shadow-xl rounded-md ">
                    <div class="bg-gray-50 dark:bg-gray-700 text-center rounded-md">
                        <div class="flex justify-center items-center">
                            <div class="flex-grow">
                                <h2 class="text-lg text-gray-800 dark:text-white font-bold p-2 mb-4">Responder Questões
                                </h2>
                            </div>
                            @can('aluno')
                            <div class="ml-auto mr-2">
                                <h3 class="text-lg text-gray-800 dark:text-white font-bold p-2">10% Acertos</h3>
                            </div>
                            @endcan
                        </div>
                    </div>

                    <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        @forelse ($this->questions as $question)
                        <div
                            class="mb-4 border border-gray-300  dark:border-gray-700 rounded-md p-4
                                    {{ $question->response_status == 'correto' ? 'bg-green-100 border-green-300 dark:border-green-700 dark:bg-green-900' : '' }}
                                    {{ $question->response_status == 'errado' ? 'bg-red-100 border-red-300 dark:border-red-700 dark:bg-red-900': '' }}
                                    {{ $question->response_status == 'pendente' ? 'bg-gray-100 border-gray-300 dark:border-gray-700 dark:bg-gray-900' : '' }}">
                            <div class="flex flex-row justify-between">
                                <h3 class="text-lg font-semibold mb-4 mr-10">{{ $question->title }}</h3>
                                @can('admin')
                                <div class="flex flex-row">
                                    <button wire:click.prevent="edit({{ $question->id }})" class="mr-2">
                                        <x-svg.edit />
                                    </button>
                                    <button wire:click.prevent="dell({{ $question->id }})">
                                        <x-svg.delete />
                                    </button>
                                </div>
                                @endcan
                            </div>
                            @if ($question->type === 'aberta')
                            @if ($question->response)
                            {{ $question->response }}
                            @else
                            <textarea {{ auth()->check() && auth()->user()->hasPermissionTo('admin') ? 'disabled' : '' }} type="text" wire:model.lazy="answers.{{ $question->id }}" class="input-form"
                                placeholder="Sua resposta"> </textarea>
                            @endif
                            @error("answers.{$question->id}")
                            <span class="text-red-500">{{ $message }}</span>
                            @enderror
                            @elseif ($question->type === 'multi')
                            @if ($question->response)
                            {{ $question->response }}
                            @else
                            @forelse (json_decode($question->options) as $index => $option)
                            <label class="flex items-center">
                                <input {{ auth()->check() && auth()->user()->hasPermissionTo('admin') ? 'disabled' : ''
                                }} type="radio" name="question_{{ $question->id }}"
                                wire:model="answers.{{ $question->id }}" value="{{ $option->text }}" class="mr-2" {{
                                $question->response == $option->text ? 'checked' : '' }}>
                                <span class="text-sm">{{ $option->text }}</span>
                            </label>
                            @empty
                            <span class="text-red-500">Nenhuma opção cadastrada</span>
                            @endforelse
                            @endif
                            @error("answers.{$question->id}")
                            <span class="text-red-500">{{ $message }}</span>
                            @enderror
                            @endif
                        </div>
                        @empty
                        <span class="text-red-500">Nenhuma questão cadastrada</span>
                        @endforelse
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 px-4 rounded py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                            <button type="button" wire:click.prevent="storeQuestion()" {{ $checkResponse==true
                                ? 'disabled' : '' }} class="btn-submit {{ $checkResponse==true ? 'opacity-50' : '' }}">
                                Salvar
                            </button>
                        </span>
                    </div>
                </div>
            </form>
            @endif
        </div>
        {{--Correção--}}
        @can('admin')
        <div class="col-span-4">
            <div class="bg-white dark:bg-slate-800 shadow-xl rounded-md">
                <div class="bg-gray-50 dark:bg-gray-700 text-center rounded-md">
                    <h2 class="text-lg text-gray-800 dark:text-white font-bold p-2 mb-4">Correção</h2>
                </div>
                <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    @forelse ($this->userQuestions as $user)
                    <div class="flex mb-4">
                        <img class="w-8 h-8 bg-black rounded-full mr-2" src="{{ asset($user->profile_photo_url) }}"
                            width="32" height="32" alt="{{ $user->name }}" />
                        <span class="flex-1 truncate ml-2 text-sm font-medium group-hover:text-slate-800">
                            {{ $user->name }}
                            <div class="flex flex-row">
                                <small class="pr-2">Pendentes: {{ $user->respostas_pendente }}</small>
                                <small class="pr-2">Corretas: {{ $user->respostas_correta }}</small>
                                <small class="pr-2">Erradas: {{ $user->respostas_errado }}</small>
                            </div>
                        </span>
                        @if ($user->respostas_pendente > 0)
                        <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                            <button type="button" wire:click.prevent="correctAnswers({{$user->id}})" class="btn-submit">
                                Corrigir
                            </button>
                        </span>
                        @else
                        {{ $user->porcentagem_acertos }}
                        @endif
                    </div>
                    @empty
                    <span class="text-red-500">Nenhum usuário respondeu</span>
                    @endforelse
                </div>
            </div>
        </div>
        @endcan
    </div>
</div>
