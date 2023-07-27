<x-dialog-modal id="myModal" wire:model="isOpen" maxWidth="2xl" closeModal="closeModal()">
    <x-slot name="title">
        @if (!empty($_id))
        Atualizar Evento
        @else
        Adicionar Evento
        @endif
    </x-slot>

    <x-slot name="content">
        <form>
            <div class="md:flex">
                <div class="md:w-1/2 p-1">
                    <div class="mb-4">
                        <label for="campType"
                            class="label-input-form">Tipo</label>
                        <select id="campType" wire:model="type"
                            class="input-form">
                            <option value="">Selecione o tipo</option>
                            @foreach ($typesList as $type)
                                <option value="{{ $type->name }}">{{ $type->value }}</option>
                            @endforeach
                        </select>
                        @error('type')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="campCategory"
                            class="label-input-form">Categoria</label>
                        <select id="campCategory" wire:model="category_id"
                            class="input-form">
                            <option value="">Selecione uma categoria</option>
                            @foreach ($categoryList as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
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
                        <label for="campDataStart"
                            class="label-input-form">Data
                            Início</label>
                        <input type="datetime-local"
                            class="input-form"
                            id="campDataStart" placeholder="Informe a data de início" wire:model.lazy="start_date">
                        @error('start_date')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="campDataEnd"
                            class="label-input-form">Data
                            Término:</label>
                        <input type="datetime-local"
                            class="input-form"
                            id="campDataEnd" placeholder="Informe a data de término" wire:model.lazy="end_date">
                        @error('end_date')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="campLocal"
                            class="label-input-form">Local:</label>
                        <input type="text"
                            class="input-form"
                            id="campLocal" placeholder="Informe o local" wire:model.lazy="local">
                        @error('local')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="campImg"
                            class="label-input-form">Imagem</label>
                        <input type="file" wire:model="newImage"
                            class="label-input-form">
                        @error('newImage')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                        @error('image')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror

                        @if ($newImage)
                            <img src="{{ $newImage->temporaryUrl() }}" alt="Nova Imagem Selecionada"
                                class="mt-2 w-32 h-auto">
                        @elseif ($image != '')
                            <img src="{{ asset($image) }}" alt="Imagem Atual" class="mt-2 w-32 h-auto">
                        @endif
                    </div>
                </div>
                <div class="md:w-1/2 p-1">
                    <div class="mb-4">
                        <label for="campTickets"
                            class="label-input-form">Vagas:</label>
                        <input type="number"
                            class="input-form"
                            id="campTickets" placeholder="Limite de vagas" wire:model.lazy="tickets_limit">
                        @error('tickets_limit')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="campValue"
                            class="label-input-form">Valor:</label>
                        <input type="number"
                            class="input-form"
                            id="campValue" placeholder="Informe o valor" wire:model.lazy="value">
                        @error('value')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <label for="campDescription"
                            class="label-input-form">Descrição:</label>
                        <textarea
                            class="input-form"
                            id="campDescription" wire:model.lazy="description" placeholder="Informe a descrição"
                            rows="5"></textarea>
                        @error('description')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="countries"
                            class="label-input-form">Status</label>
                        <select id="countries" wire:model="status"
                            class="input-form">
                            <option value="">Selecione o status</option>
                            @foreach ($statusList as $status)
                                <option value="{{ $status->name }}">{{ $status->value }}</option>
                            @endforeach
                        </select>
                        @error('status')
                        <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </form>
    </x-slot>

    <x-slot name="footer">
        <span class="flex w-full rounded-md shadow-sm  sm:w-auto">
            <button wire:click.prevent="store()" type="button"
                class="btn-submit">
                @if (!empty($_id))
                Atualizar
                @else
                Salvar
                @endif
            </button>
        </span>
        <span class="flex w-full rounded-md shadow-sm sm:w-auto">
            <button wire:click.prevent="closeModal()" type="button"
                class="btn-default">
                Cancel
            </button>
        </span>
    </x-slot>
</x-dialog-modal>
