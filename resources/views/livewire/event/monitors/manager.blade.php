<div>
    <button wire:click.prevent="$set('isOpenMonitors', true)" class="btn-primary ">
        <x-icon-people-group class="w-5 h-5" />
        <span class="ml-2">Monitores</span>
    </button>
    @if ($isOpenMonitors)
        <x-dialog-modal id="myModal" wire:model.defer="isOpenMonitors" maxWidth="2xl" closeModal="$set('isOpenMonitors', false)">
            <x-slot name="title">
                @if (!empty($_id))
                Atualizar Monitor
                @else
                Adicionar Monitor
                @endif
            </x-slot>

            <x-slot name="content">
                <form>
                    <div class="px-4 mb-4 pb-4 sm:p-6 sm:pb-4 text-left">
                        <div class="font-bold  flex items-center">
                            <div class="relative mr-4 flex">
                                <input wire:model.debounce.300ms="search" placeholder="Buscar monitor..."
                                    class="form-input peer h-full rounded-full bg-slate-150 px-4 pl-9 text-xs+ text-slate-800 ring-primary/50 hover:bg-slate-200 focus:ring dark:bg-navy-900/90 dark:text-navy-100 dark:placeholder-navy-300 dark:ring-accent/50 dark:hover:bg-navy-900 dark:focus:bg-navy-900 w-60"
                                    type="text">
                                <div
                                    class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-colors duration-200"
                                        fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M3.316 13.781l.73-.171-.73.171zm0-5.457l.73.171-.73-.171zm15.473 0l.73-.171-.73.171zm0 5.457l.73.171-.73-.171zm-5.008 5.008l-.171-.73.171.73zm-5.457 0l-.171.73.171-.73zm0-15.473l-.171-.73.171.73zm5.457 0l.171-.73-.171.73zM20.47 21.53a.75.75 0 101.06-1.06l-1.06 1.06zM4.046 13.61a11.198 11.198 0 010-5.115l-1.46-.342a12.698 12.698 0 000 5.8l1.46-.343zm14.013-5.115a11.196 11.196 0 010 5.115l1.46.342a12.698 12.698 0 000-5.8l-1.46.343zm-4.45 9.564a11.196 11.196 0 01-5.114 0l-.342 1.46c1.907.448 3.892.448 5.8 0l-.343-1.46zM8.496 4.046a11.198 11.198 0 015.115 0l.342-1.46a12.698 12.698 0 00-5.8 0l.343 1.46zm0 14.013a5.97 5.97 0 01-4.45-4.45l-1.46.343a7.47 7.47 0 005.568 5.568l.342-1.46zm5.457 1.46a7.47 7.47 0 005.568-5.567l-1.46-.342a5.97 5.97 0 01-4.45 4.45l.342 1.46zM13.61 4.046a5.97 5.97 0 014.45 4.45l1.46-.343a7.47 7.47 0 00-5.568-5.567l-.342 1.46zm-5.457-1.46a7.47 7.47 0 00-5.567 5.567l1.46.342a5.97 5.97 0 014.45-4.45l-.343-1.46zm8.652 15.28l3.665 3.664 1.06-1.06-3.665-3.665-1.06 1.06z">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="max-h-80 overflow-y-auto py-4 px-4">
                            @foreach ($optMonitors as $monitor)
                            <label class="flex items-center space-x-2">
                                <input wire:model="monitors" type="checkbox" value="{{ $monitor->id }}" class="form-checkbox">
                                <span>{{ $monitor->name }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                </form>
            </x-slot>
            <x-slot name="footer">
                <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                    <button wire:click.prevent="storeMonitors()" type="button"
                        class="btn-submit">
                        @if (!empty($_id))
                        Atualizar
                        @else
                        Salvar
                        @endif
                    </button>
                </span>
                <span class="flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                    <button wire:click="$set('isOpenMonitors', false)" type="button"
                        class="btn-default">
                        Fechar
                    </button>
                </span>
            </x-slot>
        </x-dialog-modal>
    @endif
</div>

