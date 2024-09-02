<div>
    @if (session()->has('message'))
    <x-alert-message :message="session('message')['text']" :messageType="session('message')['type']" />
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
        <div class="bg-white border-t-2 dark:border-indigo-900  dark:bg-slate-800 shadow-xl rounded-md">
            <div class="bg-gray-50 dark:bg-gray-700 text-center rounded-t-md">
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
                            <span class="text-sm">Única Escolha</span>
                        </label>
                        <label>
                            <input wire:model="type" type="radio" value="multiple" class="mr-1 ml-4">
                            <span class="text-sm">Mulitpla Escolha</span>
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
                @if ($type === 'multi' || $type === 'multiple')
                <div class="mb-4">
                    <label class="label-input-form">Opções:</label>
                    @if (!is_null($options))
                    @foreach ($options as $index => $option)
                    <div class="flex items-center mb-2">
                        <input wire:model.lazy="options.{{ $index }}.text" type="text" class="input-form">
                        <label class="ml-2">
                            <input wire:model="options.{{ $index }}.correct" type="checkbox"
                                class="mr-1 border-gray-400" wire:key="{{ $index }}">
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
            <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 rounded-b-md sm:px-6 sm:flex sm:flex-row-reverse mb-4">
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
    <div class="flex flex-col md:flex-row items-start justify-between gap-2">
        <div class=" w-full">
            @if ($viewCorrectAnswers)
            <livewire:event-activity-question-correct :userId="$userCorrectAnswer" :eventId="$eventId" :atvId="$atvId" :key="rand()" />
            @else
            <form class="">
                <div class="bg-white border-t-2 dark:border-indigo-900 dark:bg-slate-800 shadow-xl rounded-md ">
                    <div class="bg-gray-50 dark:bg-gray-700 text-center rounded-t-md">
                        <div class="flex flex-col gap-4 justify-center items-center h-full p-2">
                            <div class="flex-grow">
                                <h2 class="text-lg text-gray-800 dark:text-white font-bold ">
                                    Responder Questões
                                </h2>
                            </div>
                            @can('aluno')
                            @if ($this->questions['checkResponse']==true)
                            <div class="ml-auto mr-2">
                                <h3 class="text-lg text-gray-800 dark:text-white font-bold">
                                    @if (strpos($this->questions['correct'], '%') !== false)
                                    <span class="{{ $this->questions['correct'] >= 60 ? 'text-green-600' : 'text-red-600' }}">{{ $this->questions['correct'] }} Acertos</span>
                                    @else
                                    <span class="text-red-600">{{ $this->questions['correct'] }}</span>
                                    @endif
                                </h3>
                            </div>
                            @endif
                            @endcan
                        </div>
                    </div>

                    <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        @forelse ($this->questions['data'] as $question)
                        <div
                            class="
                                mb-4
                                border
                                border-gray-300
                                dark:border-gray-700
                                rounded-md p-4
                                {{ $question->response_status == 'correto' ? 'bg-green-100 border-green-300 dark:border-green-800 dark:bg-green-900' : '' }}
                                {{ $question->response_status == 'errado' ? 'bg-red-100 border-red-300 dark:border-red-700 dark:bg-red-900': '' }}
                                {{ $question->response_status == 'pendente' ? 'bg-gray-100 border-gray-300 dark:border-gray-700 dark:bg-gray-900' : '' }}"
                            >
                            <div class="flex flex-row justify-between">
                                <h3 class="text-lg font-semibold mb-4 mr-10 whitespace-pre-line">{{ $question->title }}</h3>
                                @can('admin')
                                <div class="flex flex-row gap-1">
                                    <button wire:click.prevent="edit({{ $question->id }})" class="mr-2 btn-icon">
                                        <x-icon-pencil class="h-5 w-5" />
                                    </button>
                                    <button wire:click.prevent="dell({{ $question->id }})" class=" btn-icon">
                                        <x-icon-trash class="h-5 w-5" />
                                    </button>
                                </div>
                                @endcan
                            </div>
                            @if ($question->type === 'aberta')
                                @if ($question->response)
                                    {{ $question->response }}
                                @else
                                    <textarea
                                        {{ auth()->check() && auth()->user()->hasPermissionTo('admin') ? 'disabled' : '' }}
                                        type="text"
                                        wire:model.lazy="answers.{{ $question->id }}"
                                        class="input-form"
                                        placeholder="Sua resposta"
                                    ></textarea>
                                @endif
                                @error("answers.{$question->id}")
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            @elseif ($question->type === 'multi')
                                @if ($question->response)
                                    <p>Resposta: {{ $question->response }}</p>
                                    @if ($question->response_status == 'errado')
                                        <small>Correta: {{ $this->getCorrectOption($question->options) }}</small>
                                    @endif
                                @else
                                    @forelse (json_decode($question->options) as $index => $option)
                                        <label class="flex items-center">
                                            <input
                                                {{ auth()->check() && auth()->user()->hasPermissionTo('admin') ? 'disabled' : '' }}
                                                type="radio"
                                                name="question_{{ $question->id }}"
                                                wire:model="answers.{{ $question->id }}"
                                                value="{{ $option->text }}"
                                                class="mr-2 {{ auth()->user()->hasPermissionTo('admin') && $option->correct ? 'bg-green-600' : '' }}"
                                                {{ $question->response == $option->text ? 'checked' : '' }}
                                            >
                                            <span class="text-sm">{{ $option->text }}</span>
                                        </label>
                                    @empty
                                        <span class="text-red-500">Nenhuma opção cadastrada</span>
                                    @endforelse
                                @endif
                                @error("answers.{$question->id}")
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            @elseif ($question->type === 'multiple')
                                @if ($question->response)
                                    <p>Resposta: {{ $question->response }}</p>
                                    @if ($question->response_status == 'errado')
                                        <small>Correta: {{ $this->getCorrectOption($question->options) }}</small>
                                    @endif
                                @else
                                    @forelse (json_decode($question->options) as $index => $option)
                                        <label class="flex items-center">
                                            <input
                                                {{ auth()->check() && auth()->user()->hasPermissionTo('admin') ? 'disabled' : '' }}
                                                type="checkbox"
                                                name="question_{{ $question->id }}.{{ $option->text }}"
                                                wire:model="answers.{{ $question->id }}.{{ $option->text }}"
                                                value="check"
                                                class="mr-2 {{ auth()->user()->hasPermissionTo('admin') && $option->correct ? 'bg-green-600' : '' }}"
                                                {{ $question->response == $option->text ? 'checked' : '' }}
                                            >
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
                    @can('aluno')
                        <div class="bg-gray-50 dark:bg-gray-700 px-4 rounded py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <span class="flex w-full sm:ml-3 sm:w-auto">
                                @can(['monitorEvent'], $eventId)
                                    <p class="text-red-500">Selecione um aluno ao lado para corrigir.</p>
                                @else
                                    @if (
                                        (isset($this->questions['data'][0]->activity->start_date) && Carbon\Carbon::parse($this->questions['data'][0]->activity->start_date) >= Carbon\Carbon::parse(date('Y-m-d H:i:s')))
                                        ||
                                        (isset($this->questions['data'][0]->activity->end_date) && Carbon\Carbon::parse($this->questions['data'][0]->activity->end_date) < Carbon\Carbon::parse(date('Y-m-d H:i:s')))
                                    )
                                        <p class="text-red-500">Fora do prazo para envio da atividade.</p>
                                    @else
                                        <button
                                            type="button"
                                            wire:click.prevent="storeQuestion()"
                                            class="btn-submit {{ $this->questions['checkResponse']==true ? 'opacity-50' : '' }}"
                                            {{ $this->questions['checkResponse']==true ? 'disabled' : '' }}
                                        >
                                            Salvar
                                        </button>
                                    @endif
                                @endcan
                            </span>
                        </div>
                    @endcan
                </div>
            </form>
            @endif
        </div>
        {{--Correção--}}
        @can(['monitorEvent'], $eventId)
        <div class="w-full sm:basis-1/2">
            <div class="bg-white border-t-2 dark:border-indigo-900 dark:bg-slate-800 shadow-xl rounded-md">
                <div class="bg-gray-50 dark:bg-gray-700 text-center rounded-t-md">
                    <h2 class="text-lg text-gray-800 dark:text-white font-bold p-2 mb-4">Correção</h2>
                </div>
                <div class="relative ml-4 flex">
                    <x-search-form placeholder="Buscar aluno..." />
                </div>
                <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4 max-h-[350px] overflow-auto">
                    @forelse ($this->userQuestions as $user)
                    <div class="flex  flex-row justify-start items-start py-2 px-4 mb-2 {{round(($user->correct_answers / $user->all_answers) * 100, 1) < 60 ? 'bg-infor' : ''}}">
                        <span class="flex-1 truncate ml-2 text-sm font-medium group-hover:text-slate-800">
                            {{ $user->name }}
                            <div class="flex flex-row mt-1">
                                <div class="flex items-center">
                                    <button data-tooltip-target="tooltip-pendencias" type="button" class="btn-icon btn-tooltip">
                                        <x-icon-circle-exclamation class="h-4 w-4 text-yellow-500" />
                                    </button>
                                    <small class="pr-2 ml-1">{{ $user->pending_answers }}</small>
                                    <div id="tooltip-pendencias" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                         Pendência
                                        <div class="tooltip-arrow" data-popper-arrow></div>
                                    </div>
                                </div>
                                <div class="flex items-center">
                                    <button data-tooltip-target="tooltip-corretas" type="button" class="btn-icon btn-tooltip">
                                        <x-icon-circle-check class="h-4 w-4 text-green-500" />
                                    </button>
                                    <small class="pr-2 ml-1"> {{$user->correct_answers }}</small>
                                    <div id="tooltip-corretas" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                         Corretas
                                        <div class="tooltip-arrow" data-popper-arrow></div>
                                    </div>
                                </div>
                                <div class="flex items-center">
                                    <button data-tooltip-target="tooltip-erradas" type="button" class="btn-icon btn-tooltip">
                                        <x-icon-circle-xmark class="h-4 w-4 text-red-500" />
                                    </button>
                                    <small class="pr-2 ml-1"> {{$user->wrong_answers }}</small>
                                    <div id="tooltip-erradas" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                         Erradas
                                        <div class="tooltip-arrow" data-popper-arrow></div>
                                    </div>
                                </div>

                            </div>
                        </span>

                        @if ($user->pending_answers > 0)
                        <div class="ml-3">
                            <button
                                wire:click.prevent="correctAnswers({{$user->id}})" type="button"
                                class="btn-primary">
                                <x-icon-circle-check class="h-4 w-4 " /> <small class="pr-2 ml-1"> Corrigir</small>
                            </button>
                        </div>
                        @else
                        <div class="flex flex-col items-center gap-1">
                            {{ ($user->pending_answers <= 0) ? round(($user->correct_answers / $user->all_answers) * 100, 1).'%' : 'Pendente de correção' }}
                        </div>
                        @endif
                    </div>
                    @empty
                    <span class="text-red-500">Nenhum usuário respondeu</span>
                    @endforelse
                </div>
            </div>
        </div>
        @endcan
        @can(['admin'], $eventId)
        <div class="w-full sm:basis-1/2">
            <div class="bg-white border-t-2 dark:border-indigo-900 dark:bg-slate-800 shadow-xl rounded-md">
                <div class="bg-gray-50 dark:bg-gray-700 text-center rounded-t-md">
                    <h2 class="text-lg text-gray-800 dark:text-white font-bold p-2 mb-4">Correção</h2>
                </div>
                <div class="relative ml-4 flex">
                    <x-search-form placeholder="Buscar aluno..." />
                </div>
                <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4 max-h-[350px] overflow-auto">
                    @forelse ($this->userQuestions as $user)
                    <div class="flex  flex-row justify-start items-start py-2 px-4 mb-2 {{round(($user->correct_answers / $user->all_answers) * 100, 1) < 60 ? 'bg-infor' : ''}}">
                        <span class="flex-1 truncate ml-2 text-sm font-medium group-hover:text-slate-800">
                            {{ $user->name }}
                            <div class="flex flex-row mt-1">
                                <div class="flex items-center">
                                    <button data-tooltip-target="tooltip-pendencias" type="button" class="btn-icon btn-tooltip">
                                        <x-icon-circle-exclamation class="h-4 w-4 text-yellow-500" />
                                    </button>
                                    <small class="pr-2 ml-1">{{ $user->pending_answers }}</small>
                                    <div id="tooltip-pendencias" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                         Pendência
                                        <div class="tooltip-arrow" data-popper-arrow></div>
                                    </div>
                                </div>
                                <div class="flex items-center">
                                    <button data-tooltip-target="tooltip-corretas" type="button" class="btn-icon btn-tooltip">
                                        <x-icon-circle-check class="h-4 w-4 text-green-500" />
                                    </button>
                                    <small class="pr-2 ml-1"> {{$user->correct_answers }}</small>
                                    <div id="tooltip-corretas" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                         Corretas
                                        <div class="tooltip-arrow" data-popper-arrow></div>
                                    </div>
                                </div>
                                <div class="flex items-center">
                                    <button data-tooltip-target="tooltip-erradas" type="button" class="btn-icon btn-tooltip">
                                        <x-icon-circle-xmark class="h-4 w-4 text-red-500" />
                                    </button>
                                    <small class="pr-2 ml-1"> {{$user->wrong_answers }}</small>
                                    <div id="tooltip-erradas" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                         Erradas
                                        <div class="tooltip-arrow" data-popper-arrow></div>
                                    </div>
                                </div>

                            </div>
                        </span>

                        @if ($user->pending_answers > 0)
                        <div class="ml-3">
                            <button
                                wire:click.prevent="correctAnswers({{$user->id}})" type="button"
                                class="btn-primary">
                                <x-icon-circle-check class="h-4 w-4 " /> <small class="pr-2 ml-1"> Corrigir</small>
                            </button>
                        </div>
                        @else
                        <div class="flex flex-col items-center gap-1">
                            {{ ($user->pending_answers <= 0) ? round(($user->correct_answers / $user->all_answers) * 100, 1).'%' : 'Pendente de correção' }}
                            <button
                                wire:click.prevent="correctAnswers({{$user->id}})" type="button"
                                class="btn-primary">
                                <x-icon-circle-check class="h-4 w-4 " /> <small class="pr-2 ml-1"> Ver</small>
                            </button>
                        </div>
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
