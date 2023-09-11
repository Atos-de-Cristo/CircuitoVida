<div>
    <button wire:click.prevent="$set('isOpenDif', true)" class="btn-primary text-xs ml-2">
        <x-icon-cloud-arrow-up  />
    </button>
    @if ($isOpenDif)
        <x-dialog-modal id="isOpenDif" wire:model="isOpenDif" maxWidth="xl" closeModal="$set('isOpenDif', false)">
            <x-slot name="title">
                Diferenças
            </x-slot>

            <x-slot name="content">
                <div class="flex justify-center flex-row gap-2">
                    <div class="flex-1">
                        <h2 class="text-lg font-semibold mb-4">Valores Antes</h2>
                        <ul>
                            @foreach ($old_values as $key => $value)
                                <li>
                                    <p class="break-all">{{ $key }}</p>
                                </li>
                                <li class="pl-2">
                                    <small class="break-all">{{ $value }}</small>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="flex-1">
                        <h2 class="text-lg font-semibold mb-4">Valores Após</h2>
                        <ul>
                            @foreach ($new_values as $key => $value)
                                <li>
                                    <p class="break-all">{{ $key }}</p>
                                </li>
                                <li class="pl-2">
                                    <small class="break-all">{{ $value }}</small>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </x-slot>

            <x-slot name="footer">
                <span class="flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                    <button wire:click="$set('isOpenDif', false)" type="button" class="btn-default">
                        Fechar
                    </button>
                </span>
            </x-slot>
        </x-dialog-modal>
    @endif
</div>
