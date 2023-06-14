<x-dialog-modal id="myModal" maxWidth="xl" closeModal="closeModal()">
    <x-slot name="title">
        @if (!empty($_id))
            Atualizar Usuário
        @else
            Adicionar Usuário
        @endif
    </x-slot>

    <x-slot name="content">
        <form>
            <div class="p-1">
                <div class="mb-4">
                    <label for="campName"
                        class="label-input-form">Nome:</label>
                    <input type="text"
                        class="input-form"
                        id="campName" placeholder="Entre com um nome" wire:model.lazy="name">
                    @error('name')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="campEmail"
                        class="label-input-form">Email:</label>
                    <input type="text"
                        class="input-form"
                        id="campEmail" placeholder="Entre com um email" wire:model.lazy="email">
                    @error('email')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="campPasword"
                        class="label-input-form">Senha:</label>
                    <input type="password"
                        class="input-form"
                        id="campPasword" placeholder="Entre com uma senha" wire:model.lazy="password">
                    @error('password')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="campPermission"
                        class="label-input-form">Permissão</label>
                    @forelse($permissionData as $opt)
                        @can('admin')
                            <div class="block">
                                <div class="mt-2">
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" wire:model="permissions" value="{{ $opt['id'] }}" />
                                        <span class="ml-2">{{ $opt['permission'] }}</span>
                                    </label>
                                </div>
                            </div>
                        @endcan
                        @can('monitor')
                            <div class="block">
                                <div class="mt-2">
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" wire:model="permissions" value="{{ $opt['id'] }}"
                                            @if ($opt['permission'] != 'user') disabled @endif />
                                        <span class="ml-2">{{ $opt['permission'] }}</span>
                                    </label>
                                </div>
                            </div>
                        @endcan
                    @empty
                        <p>Nenhuma permissao encontrada</p>
                    @endforelse
                    @error('type')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </form>

    </x-slot>

    <x-slot name="footer">
        <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
            <button wire:click.prevent="store()" type="button"
                class="btn-submit">

                @if (!empty($_id))
                    Atualizar
                @else
                    Salvar
                @endif
            </button>
        </span>
        <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">

            <button wire:click="closeModal()" type="button"
                class="btn-default">
                Cancelar
            </button>
        </span>
    </x-slot>
</x-dialog-modal>
