<div>
    @empty($attachmentId)
        <button wire:click.prevent="$set('isOpenAttachment', true)" class="btn-primary text-xs ml-2">
            <svg fill="#ffffff" class="w-4 h-4" viewBox="0 0 32 32" version="1.1"
                xmlns="http://www.w3.org/2000/svg" stroke="#ffffff">
                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                <g id="SVGRepo_iconCarrier">
                    <title>upload-cloud</title>
                    <path
                        d="M0 16v-1.984q0-3.328 2.336-5.664t5.664-2.336q1.024 0 2.176 0.352 0.576-2.752 2.784-4.544t5.056-1.824q3.296 0 5.632 2.368t2.368 5.632q0 0.896-0.32 2.048 0.224-0.032 0.32-0.032 2.464 0 4.224 1.76t1.76 4.224v2.016q0 2.496-1.76 4.224t-4.224 1.76h-0.384q0.288-0.8 0.352-1.44 0.096-1.312-0.32-2.56t-1.408-2.208l-4-4q-1.76-1.792-4.256-1.792t-4.224 1.76l-4 4q-0.96 0.96-1.408 2.24t-0.32 2.592q0.032 0.576 0.256 1.248-2.72-0.608-4.512-2.784t-1.792-5.056zM10.016 22.208q-0.096-0.96 0.576-1.6l4-4q0.608-0.608 1.408-0.608 0.832 0 1.408 0.608l4 4q0.672 0.64 0.608 1.6-0.032 0.288-0.16 0.576-0.224 0.544-0.736 0.896t-1.12 0.32h-1.984v6.016q0 0.832-0.608 1.408t-1.408 0.576-1.408-0.576-0.576-1.408v-6.016h-2.016q-0.608 0-1.088-0.32t-0.768-0.896q-0.096-0.288-0.128-0.576z">
                    </path>
                </g>
            </svg>
        </button>
    @else
        <button wire:click.prevent="$set('isOpenAttachment', true)" class="mr-2">
            <img src="{{ asset('svg/edit.svg') }}" alt="Ícone">
        </button>
        <button wire:click.prevent="dellAttachment()">
            <img src="{{ asset('svg/delete.svg') }}" alt="Ícone">
        </button>
    @endempty

    @if ($isOpenAttachment)
        <div class="fixed z-40 inset-0 overflow-y-auto ease-out duration-400">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

                <div class="fixed inset-0 transition-opacity">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>

                <!-- This element is to trick the browser into centering the modal contents. -->
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>​

                <div class="
                    inline-block
                    align-bottom
                    bg-white
                    rounded-lg
                    text-left
                    overflow-hidden
                    shadow-xl
                    transform
                    transition-all
                    sm:my-8
                    sm:align-middle
                    sm:max-w-2xl
                    sm:w-full
                "
                    role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                    <form>
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="md:flex">
                                <div class="mb-4">
                                    <label for="campName" class="block text-gray-700 text-sm font-bold mb-2">Nome:</label>
                                    <input
                                        type="text"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        id="campName"
                                        placeholder="Entre com o nome"
                                        wire:model="name"
                                    >
                                    @error('name')
                                        <span class="text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                                @empty($attachmentId)
                                <div class="md:w-1/2 p-1">
                                    <div class="mb-4">
                                        <label for="campImg" class="block text-gray-700 text-sm font-bold mb-2">Anexo</label>
                                        <input type="file" wire:model="attachment">
                                        @error('attachment')
                                            <span class="text-red-500">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                @endempty
                            </div>
                        </div>

                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                                <button wire:click.prevent="store()" type="button"
                                    class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                                    Salvar
                                </button>
                            </span>
                            <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                                <button wire:click.prevent="$set('isOpenAttachment', false)" type="button"
                                    class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                                    Fechar
                                </button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
