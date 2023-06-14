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
                        class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Nome:</label>
                    <input type="text"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 leading-tight focus:outline-none focus:shadow-outline"
                        id="campName" placeholder="Entre com um nome" wire:model.lazy="name">
                    @error('name')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="campEmail"
                        class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Email:</label>
                    <input type="text"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 leading-tight focus:outline-none focus:shadow-outline"
                        id="campEmail" placeholder="Entre com um email" wire:model.lazy="email">
                    @error('email')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="campPasword"
                        class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Senha:</label>
                    <input type="password"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 leading-tight focus:outline-none focus:shadow-outline"
                        id="campPasword" placeholder="Entre com uma senha" wire:model.lazy="password">
                    @error('password')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="campPermission"
                        class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Permissão</label>
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
                class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5">

                @if (!empty($_id))
                    Atualizar
                @else
                    Salvar
                @endif
            </button>
        </span>
        <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">

            <button wire:click="closeModal()" type="button"
                class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                Cancelar
            </button>
        </span>
    </x-slot>
</x-dialog-modal>
