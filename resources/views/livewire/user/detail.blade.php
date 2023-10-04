<div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
    <div class="sm:col-span-2 md:col-span-1">
        <div
            class="bg-white border-t-2 dark:border-indigo-900 dark:bg-slate-700 overflow-hidden shadow-xl rounded-md   mt-2 mb-4  ">
            <div class="dark:bg-gradient-to-r from-indigo-900 to-indigo-600 h-16 rounded-t-lg p-2">
                <div class="  bg-slate-700 w-20 h-20 rounded-full flex items-center justify-center">
                    <div class="w-16 h-16 flex  border-2 border-white rounded-full overflow-hidden">
                        <img
                            src="{{ asset($this->user->profile_photo_url) }}"
                            alt="{{ $this->user->name }}"
                            class="object-cover h-full w-full cursor-pointer"
                        >
                    </div>
                </div>
            </div>
            <div class="px-4 py-2">
                <h1 class="text-xl font-bold mt-5 sm:mb-0">{{ $this->user->name }}</h1>
                <p class="">{{ $this->user->email }}</p>
            </div>
        </div>
        <div class="">
            <livewire:profile :userId="$this->user->id" />
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
                    <livewire:user-list-courses :user="$this->user" :activity="$this->activity" :key="rand()" />
                @endif
                @if ($tab === 'atividades')
                    <livewire:user-activity :user="$this->user->id" :key="rand()" />
                @endif
                @if ($tab === 'anexos')
                    <livewire:user-attachments :user="$this->user->id" :key="rand()" />
                @endif
                @if ($tab === 'message')
                    <livewire:user-message :user="$this->user->id" :key="rand()" />
                @endif
            </div>
        </div>
    </div>
</div>
