



<x-dialog-modal id="myModal" wire:model='isUser' maxWidth="2xl" closeModal="closeModal()">
    <x-slot name="title">
     Inscritos
    </x-slot>

    <x-slot name="content">
        <ul class="divide-y max-h-96 divide-gray-200">
            @foreach($userInscription as $item)
            <li class="flex items-center justify-between border-b  py-2">
                @isset($item->user->profile_photo_url)
                    <img class="w-8 h-8 bg-black rounded-full mr-2"
                        src="{{ asset($item->user->profile_photo_url) }}" width="32" height="32"
                        alt="{{ $item->user->name }}"
                    />
                @endisset
                @isset($item->user->name)
                    <span class="w-full md:w-1/3 px-2 mb-2 md:mb-0">{{ $item->user->name }}</span>
                @endisset
                <span class="w-full md:w-1/3 px-2 mb-2 md:mb-0">{{ getStatusInscription($item->status) }}</span>
                <span class="w-full md:w-1/3 ">
                    @if ($item->status == 'P')
                        <button wire:click.prevent="approveInscription({{ $item->id }})"
                            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 w-24 rounded">Aprovar</button>
                    @endif
                    @if ($item->status == 'L')
                        <button wire:click.prevent="disapproveInscription({{ $item->id }})"
                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4  w-24 rounded">Cancelar</button>
                    @endif
                    @if ($item->status == 'C')
                        <button wire:click.prevent="approveInscription({{ $item->id }})"
                            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4  w-24 rounded">Aprovar</button>
                    @endif
                </span>
            </li>
            @endforeach
        </ul>
    </x-slot>


    <x-slot name="footer">

        <span class="flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">

            <button wire:click.prevent="closeModal()" type="button"
                class="btn-default">
                Cancel
            </button>
        </span>
    </x-slot>
</x-dialog-modal>
