<div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

      <div class="fixed inset-0 transition-opacity">
        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
      </div>

      <!-- This element is to trick the browser into centering the modal contents. -->
      <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>​

      <div
        class="
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
        role="dialog"
        aria-modal="true"
        aria-labelledby="modal-headline"
    >
        <form>
        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
            <div class="w-1/2">
                <div class="mb-4">
                    <label for="campType" class="block text-gray-700 text-sm font-bold mb-2">Tipo</label>
                    <select
                        id="campType"
                        wire:model="type"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    >
                        @foreach ($typesList as $type)
                            <option value="{{$type->name}}">{{$type->value}}</option>
                        @endforeach
                    </select>
                    @error('type') <span class="text-red-500">{{ $message }}</span>@enderror
                </div>
                <div class="mb-4">
                    <label for="campName" class="block text-gray-700 text-sm font-bold mb-2">Nome:</label>
                    <input
                        type="text"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="campName"
                        placeholder="Entre com um nome"
                        wire:model="name"
                    >
                    @error('name') <span class="text-red-500">{{ $message }}</span>@enderror
                </div>
                <div class="mb-4">
                    <label for="campDataStart" class="block text-gray-700 text-sm font-bold mb-2">Data Início</label>
                    <input
                        type="datetime-local"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="campDataStart"
                        placeholder="Informe a data de início"
                        wire:model="start_date"
                    >
                    @error('start_date') <span class="text-red-500">{{ $message }}</span>@enderror
                </div>
                <div class="mb-4">
                    <label for="campDataEnd" class="block text-gray-700 text-sm font-bold mb-2">Data Término:</label>
                    <input
                        type="datetime-local"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="campDataEnd"
                        placeholder="Informe a data de término"
                        wire:model="start_date"
                    >
                    @error('start_date') <span class="text-red-500">{{ $message }}</span>@enderror
                </div>
                <div class="mb-4">
                    <label for="campLocal" class="block text-gray-700 text-sm font-bold mb-2">Local:</label>
                    <input
                        type="text"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="campLocal"
                        placeholder="Informe o local"
                        wire:model="local"
                    >
                    @error('local') <span class="text-red-500">{{ $message }}</span>@enderror
                </div>
                <div class="mb-4">
                    <label for="campTickets" class="block text-gray-700 text-sm font-bold mb-2">Vagas:</label>
                    <input
                        type="number"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="campTickets"
                        placeholder="Limite de vagas"
                        wire:model="tickets_limit"
                    >
                    @error('tickets_limit') <span class="text-red-500">{{ $message }}</span>@enderror
                </div>
                <div class="mb-4">
                    <label for="campValue" class="block text-gray-700 text-sm font-bold mb-2">Valor:</label>
                    <input
                        type="number"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="campValue"
                        placeholder="Informe o valor"
                        wire:model="tickets_limit"
                    >
                    @error('tickets_limit') <span class="text-red-500">{{ $message }}</span>@enderror
                </div>
                <div class="mb-4">
                    <label for="campDescription" class="block text-gray-700 text-sm font-bold mb-2">Descrição:</label>
                    <textarea
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="campDescription"
                        wire:model="description"
                        placeholder="Informe a descrição"
                    ></textarea>
                    @error('description') <span class="text-red-500">{{ $message }}</span>@enderror
                </div>
                <div class="mb-4">
                    <label for="countries" class="block text-gray-700 text-sm font-bold mb-2">Status</label>
                    <select
                        id="countries"
                        wire:model="status"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    >
                        @foreach($statusList as $status)
                            <option value="{{$status->name}}">{{$status->value}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="w-1/2">
                <div class="mb-4">
                    <label for="campType" class="block text-gray-700 text-sm font-bold mb-2">Tipo</label>
                    <select
                        id="campType"
                        wire:model="type"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    >
                        @foreach ($typesList as $type)
                            <option value="{{$type->name}}">{{$type->value}}</option>
                        @endforeach
                    </select>
                    @error('type') <span class="text-red-500">{{ $message }}</span>@enderror
                </div>
                <div class="mb-4">
                    <label for="campName" class="block text-gray-700 text-sm font-bold mb-2">Nome:</label>
                    <input
                        type="text"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="campName"
                        placeholder="Entre com um nome"
                        wire:model="name"
                    >
                    @error('name') <span class="text-red-500">{{ $message }}</span>@enderror
                </div>
                <div class="mb-4">
                    <label for="campDataStart" class="block text-gray-700 text-sm font-bold mb-2">Data Início</label>
                    <input
                        type="datetime-local"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="campDataStart"
                        placeholder="Informe a data de início"
                        wire:model="start_date"
                    >
                    @error('start_date') <span class="text-red-500">{{ $message }}</span>@enderror
                </div>
                <div class="mb-4">
                    <label for="campDataEnd" class="block text-gray-700 text-sm font-bold mb-2">Data Término:</label>
                    <input
                        type="datetime-local"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="campDataEnd"
                        placeholder="Informe a data de término"
                        wire:model="start_date"
                    >
                    @error('start_date') <span class="text-red-500">{{ $message }}</span>@enderror
                </div>
                <div class="mb-4">
                    <label for="campLocal" class="block text-gray-700 text-sm font-bold mb-2">Local:</label>
                    <input
                        type="text"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="campLocal"
                        placeholder="Informe o local"
                        wire:model="local"
                    >
                    @error('local') <span class="text-red-500">{{ $message }}</span>@enderror
                </div>
                <div class="mb-4">
                    <label for="campTickets" class="block text-gray-700 text-sm font-bold mb-2">Vagas:</label>
                    <input
                        type="number"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="campTickets"
                        placeholder="Limite de vagas"
                        wire:model="tickets_limit"
                    >
                    @error('tickets_limit') <span class="text-red-500">{{ $message }}</span>@enderror
                </div>
                <div class="mb-4">
                    <label for="campValue" class="block text-gray-700 text-sm font-bold mb-2">Valor:</label>
                    <input
                        type="number"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="campValue"
                        placeholder="Informe o valor"
                        wire:model="tickets_limit"
                    >
                    @error('tickets_limit') <span class="text-red-500">{{ $message }}</span>@enderror
                </div>
                <div class="mb-4">
                    <label for="campDescription" class="block text-gray-700 text-sm font-bold mb-2">Descrição:</label>
                    <textarea
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="campDescription"
                        wire:model="description"
                        placeholder="Informe a descrição"
                    ></textarea>
                    @error('description') <span class="text-red-500">{{ $message }}</span>@enderror
                </div>
                <div class="mb-4">
                    <label for="countries" class="block text-gray-700 text-sm font-bold mb-2">Status</label>
                    <select
                        id="countries"
                        wire:model="status"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    >
                        @foreach($statusList as $status)
                            <option value="{{$status->name}}">{{$status->value}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
          <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
            <button wire:click.prevent="store()" type="button" class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5">
              Save
            </button>
          </span>
          <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">

            <button wire:click="closeModal()" type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
              Cancel
            </button>
          </span>
          </form>
        </div>

      </div>
    </div>
  </div>
