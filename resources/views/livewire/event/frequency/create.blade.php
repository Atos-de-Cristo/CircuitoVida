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
                <table class="table-fixed w-full">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="text-left px-2 w-12">#</th>
                            <th class="text-left px-2">Nome</th>
                            <th class="text-left px-2">Email</th>
                            <td class="text-left px-2">Presente</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($event->inscriptions as $item)
                        <tr>
                            <td class="border px-2 py-2">{{ $item->user->id }}</td>
                            <td class="border px-2 py-2">{{ $item->user->name }}</td>
                            <td class="border px-2 py-2">{{ $item->user->email }}</td>
                            <td class="border px-2 py-2">
                                <input
                                    id="freq-{{ $item->user->id }}"
                                    type="checkbox"
                                    value="{{ $item->user->id }}"
                                    wire:model.lazy="users"
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                >
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                        <button wire:click.prevent="storeFrequency()" type="button"
                            class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                            Salvar
                        </button>
                    </span>
                    <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                        <button wire:click="closeModalFrequency()" type="button"
                            class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                            Fechar
                        </button>
                    </span>
                </div>
            </form>
        </div>
    </div>
</div>
