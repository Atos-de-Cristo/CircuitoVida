<div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

    <div class="sm:col-span-2 md:col-span-1">
        <div
            class="bg-white border-t-2 dark:border-indigo-900 dark:bg-slate-700 overflow-hidden shadow-xl rounded-md   mt-2 mb-4  ">
            <div class="dark:bg-gradient-to-r from-indigo-900 to-indigo-600 h-16 rounded-t-lg p-2">
                <div class="  bg-slate-700 w-20 h-20 rounded-full flex items-center justify-center">
                    <div class="w-16 h-16 flex  border-2 border-white rounded-full overflow-hidden">
                        <img src="{{ asset($this->user->profile_photo_url) }}" alt="{{ $this->user->name }}"
                            class="object-cover h-full w-full cursor-pointer">
                    </div>
                </div>
            </div>
            <div class="px-4">
                <h1 class="text-xl font-bold mt-5 sm:mb-0">{{ $this->user->name }}</h1>
                <p class="">{{ $this->user->email }}</p>
            </div>
        </div>
        <div
            class="bg-white border-t-2 dark:border-indigo-900 dark:bg-slate-700 overflow-hidden shadow-xl rounded-md mt-2 mb-4">
            @if ($this->user->profile)
            <div class="px-5">
                <div class="flex mt-4 justify-center">
                    <div class="mr-8">
                        <p class="cpf font-bold">CPF: {{$this->user->profile->cpf}}</p>
                    </div>
                    <div>
                        <p class="rg font-bold">RG: {{ $this->user->profile->rg }}</p>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4 mt-4">
                    <div>
                        <p class="sex font-bold">Sexo: {{ $this->user->profile->sex }}</p>
                    </div>
                    <div>
                        <p class="birth font-bold">Data de Nascimento:</p>
                        <p id="birth">{{ $this->user->profile->birth }}</p>
                    </div>
                    <div>
                        <p class="marital_status font-bold">Estado Civil:</p>
                        <p id="marital_status">{{ $this->user->profile->marital_status }}</p>
                    </div>
                    <div>
                        <p class="date_wedding font-bold">Data de Casamento:</p>
                        <p id="date_wedding">{{ $this->user->profile->date_wedding }}</p>
                    </div>
                    <div>
                        <p class="country font-bold">País:</p>
                        <p id="country">{{ $this->user->profile->country }}</p>
                    </div>
                    <div>
                        <p class="zip_code font-bold">CEP:</p>
                        <p id="zip_code">{{ $this->user->profile->zip_code }}</p>
                    </div>
                    <div>
                        <p class="address font-bold">Endereço:</p>
                        <p id="address">{{ $this->user->profile->address }}</p>
                    </div>
                    <div>
                        <p class="number font-bold">Número:</p>
                        <p id="number">{{ $this->user->profile->number }}</p>
                    </div>
                    <div>
                        <p class="complement font-bold">Complemento:</p>
                        <p id="complement">{{ $this->user->profile->complement }}</p>
                    </div>
                    <div>
                        <p class="district font-bold">Bairro:</p>
                        <p id="district">{{ $this->user->profile->district }}</p>
                    </div>
                    <div>
                        <p class="city font-bold">Cidade:</p>
                        <p id="city">{{ $this->user->profile->city }}</p>
                    </div>
                    <div>
                        <p class="uf font-bold">UF:</p>
                        <p id="uf">{{ $this->user->profile->uf }}</p>
                    </div>
                    <div>
                        <p class="phone font-bold">Telefone:</p>
                        <p id="phone">{{ $this->user->profile->phone }}</p>
                    </div>
                    <div>
                        <p class="cell_phone font-bold">Celular:</p>
                        <p id="cell_phone">{{$this->user->profile->cell_phone }}</p>
                    </div>
                    <div>
                        <p class="church_relationship font-bold">Relacionamento com a Igreja:</p>
                        <p id="church_relationship">{{ $this->user->profile->church_relationship }}</p>
                    </div>
                    <div>
                        <p class="entry_date font-bold">Data de Entrada: <span>{{\Carbon\Carbon::parse(
                                $this->user->profile->entry_date)->format('d/m/Y')}}</span></p>
                    </div>
                    <div>
                        <p class="hou_meet font-bold">Hora do Encontro:</p>
                        <p id="hou_meet">{{ $this->user->profile->hou_meet }}</p>
                    </div>
                    <div>
                        <p class="church_from font-bold">Igreja de Origem:</p>
                        <p id="church_from">{{ $this->user->profile->church_from }}</p>
                    </div>
                    <div>
                        <p class="baptized font-bold">Batizado:</p>
                        <p id="baptized">{{ $this->user->profile->baptized }}</p>
                    </div>
                    <div>
                        <p class="accepted_jesus font-bold">Aceitou Jesus:</p>
                        <p id="accepted_jesus">{{ $this->user->profile->accepted_jesus }}</p>
                    </div>
                    <div>
                        <p class="date_accepted_jesus font-bold">Data de Aceitação de Jesus:
                            <span>{{\Carbon\Carbon::parse(
                                $this->user->profile->date_accepted_jesus)->format('d/m/Y')}}</span>
                        </p>
                    </div>
                    <div>
                        <p class="leader font-bold">Líder:</p>
                        <p id="leader">{{ $this->user->profile->leader }}</p>
                    </div>
                    <div>
                        <p class="pastor font-bold">Pastor:</p>
                        <p id="pastor">{{ $this->user->profile->pastor }}</p>
                    </div>
                    <div>
                        <p class="schooling font-bold">Escolaridade:</p>
                        <p id="schooling">{{ $this->user->profile->schooling }}</p>
                    </div>
                    <div>
                        <p class="profession font-bold">Profissão:</p>
                        <p id="profession">{{ $this->user->profile->profession }}</p>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
    <div class="sm:col-span-2 md:col-span-2">
        <div
            class="overflow-hidden bg-white border-t-2 dark:border-indigo-900 dark:bg-slate-700 shadow-xl rounded-md mt-2">
            <div class="bg-slate-50 dark:bg-slate-800">
                <ul class="-mb-px flex flex-wrap text-center text-sm font-medium">
                    <li class="mr-2" role="presentation">
                        <button wire:click="$set('tab', 'curso')"
                            class="inline-block rounded-t-lg p-4 {{ $tab === 'curso' ? 'border-b-2 dark:border-indigo-800' : '' }}">Cursos</button>
                    </li>
                    <li class="mr-2" role="presentation">
                        <button wire:click="$set('tab', 'atividades')"
                            class="inline-block rounded-t-lg p-4 {{ $tab === 'atividades' ? 'border-b-2 dark:border-indigo-800' : '' }}">Atividades</button>
                    </li>
                    <li class="mr-2" role="presentation">
                        <button wire:click="$set('tab', 'anexos')"
                            class="inline-block rounded-t-lg p-4 {{ $tab === 'anexos' ? 'border-b-2 dark:border-indigo-800' : '' }}">Anexos</button>
                    </li>
                    <li class="mr-2" role="presentation">
                        <button wire:click="$set('tab', 'message')"
                            class="inline-block rounded-t-lg p-4 {{ $tab === 'message' ? 'border-b-2 dark:border-indigo-800' : '' }}">Messagens</button>
                    </li>
                </ul>
            </div>
            <div class="flex flex-col  gap-2 p-5 ">
                @if ($tab == 'curso')
                @forelse ($this->user->inscriptions as $inscription)
                <header class="flex flex-col bg-white dark:bg-slate-800  rounded-md sm:flex-row  justify-start">
                    <a href="{{ route('eventManager', $inscription->event->id) }}" class="sm:w-40 w-full rouded-l-md">
                        <img src="{{ asset(!empty($inscription->event->image) ? $inscription->event->image : 'images/curso.png') }}"
                            alt="{{ $inscription->name }}"
                            class="hover:scale-105  object-cover h-32 w-full sm:rounded-l-md rounded-t-md">
                    </a>

                    <div class=" p-3 ">
                        <h2 class="hover:scale-105 font-bold text-xl">{{ $inscription->event->name }}</h2>
                        <p class="nome">{{getStatusInscription($inscription->status) }}</p>

                        <div class="tags">
                            <div class="flex flex-row justify-center items-center gap-2">
                                <p class="status information text-sm font-semibold">Atividades:</p>
                                <div class="w-full sm:w-64 bg-gray-200 rounded-full dark:bg-gray-700">
                                    <div class="bg-blue-600 text-xs font-medium text-blue-100 text-center p-0.5 leading-none rounded-full"
                                        style="width: {{ $this->activity[$inscription->event_id]['responseCount'] && $this->activity[$inscription->event_id]['activityCount'] ? ($this->activity[$inscription->event_id]['responseCount'] / $this->activity[$inscription->event_id]['activityCount'] * 100) : 0 }}%"> {{ $this->activity[$inscription->event_id]['responseCount'] &&
                                        $this->activity[$inscription->event_id]['activityCount'] ?
                                        ($this->activity[$inscription->event_id]['responseCount'] /
                                        $this->activity[$inscription->event_id]['activityCount'] * 100) : 0 }}%
                                    </div>
                                </div>
                                
                            </div>
                            <div class="flex flex-row justify-center items-center gap-2">
                                <p class="status information text-sm font-semibold">Frequência:</p>
                                <div class="w-full sm:w-64 bg-gray-200 rounded-full dark:bg-gray-700">
                                    <div class="bg-blue-600 text-xs font-medium text-blue-100 text-center p-0.5 leading-none rounded-full"
                                        style="width: {{ $inscription->frequencies->count() / $inscription->event->lessons->count() * 100  }}%">
                                        {{round ($inscription->frequencies->count() / $inscription->event->lessons->count() * 100 ) }}%
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>

                @empty
                <span class="text-red-500">Nenhuma inscrição encontrada</span>
                @endforelse
                @endif
                @if ($tab === 'atividades')
                <div class="px-5 py-5">
                    <livewire:user-activity :user="$this->user->id" :key="rand()" />
                </div>
                @endif
                @if ($tab === 'anexos')
                <div class="px-5 py-5">
                    <livewire:user-attachments :user="$this->user->id" :key="rand()" />
                </div>
                @endif
                @if ($tab === 'message')
                <div class="px-5 py-5 w-full">
                    <livewire:user-message :user="$this->user->id" :key="rand()" />
                </div>
                @endif
            </div>
        </div>
    </div>
</div>