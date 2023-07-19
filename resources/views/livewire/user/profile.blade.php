<div>
    <x-form-section submit="store">
        <x-slot name="title">
            {{ __('Perfil') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Complete seu perfil.') }}
        </x-slot>

        <x-slot name="form">

            <div class="col-span-6 sm:col-span-3">
                <x-label for="cpf" value="{{ __('CPF') }}" />
                <x-input id="cpf" type="text" class="mt-1 block w-full" wire:model.defer="form.cpf" />
                <x-input-error for="form.cpf" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-3">
                <x-label for="rg" value="{{ __('RG') }}" />
                <x-input id="rg" type="text" class="mt-1 block w-full" wire:model.defer="form.rg" />
                <x-input-error for="form.rg" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-label for="sex" value="{{ __('Sexo') }}" />
                <select id="sex" wire:model.defer="form.sex"
                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                    <option value="">Selecione</option>
                    <option value="masculino">Masculino</option>
                    <option value="feminino">Feminino</option>
                </select>
                <x-input-error for="form.sex" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-label for="birth" value="{{ __('Data de Nascimento') }}" />
                <input type="date" wire:model.defer="form.birth"
                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" />
                <x-input-error for="form.birth" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-label for="marital_status" value="{{ __('Estado Civil') }}" />
                <select id="marital_status" wire:model.defer="form.marital_status"
                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                    <option value="">Selecione</option>
                    @foreach ($this->optMaritalStatus as $opt)
                    <option value="{{ $opt->name }}">{{ $opt->value }}</option>
                    @endforeach
                </select>
                <x-input-error for="form.marital_status" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-label for="date_wedding" value="{{ __('Data de Casamento') }}" />
                <input type="date" wire:model.defer="form.date_wedding"
                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" />
                <x-input-error for="form.date_wedding" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-label for="country" value="{{ __('País') }}" />
                <select id="country" wire:model.defer="form.country"
                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                    <option value="">Selecione</option>
                    <option value="brasil">Brasil</option>
                </select>
                <x-input-error for="form.marital_status" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-label for="zip_code" value="{{ __('CEP') }}" />
                <x-input id="zip_code" type="text" class="mt-1 block w-full" wire:model.defer="form.zip_code" />
                <x-input-error for="form.zip_code" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-label for="address" value="{{ __('Endereço') }}" />
                <x-input id="address" type="text" class="mt-1 block w-full" wire:model.defer="form.address" />
                <x-input-error for="form.address" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-label for="number" value="{{ __('Número') }}" />
                <x-input id="number" type="text" class="mt-1 block w-full" wire:model.defer="form.number" />
                <x-input-error for="form.number" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-label for="complement" value="{{ __('Complemento') }}" />
                <x-input id="complement" type="text" class="mt-1 block w-full" wire:model.defer="form.complement" />
                <x-input-error for="form.complement" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-label for="district" value="{{ __('Bairro') }}" />
                <x-input id="district" type="text" class="mt-1 block w-full" wire:model.defer="form.district" />
                <x-input-error for="form.district" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-label for="city" value="{{ __('Cidade') }}" />
                <x-input id="city" type="text" class="mt-1 block w-full" wire:model.defer="form.city" />
                <x-input-error for="form.city" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-label for="uf" value="{{ __('Estado') }}" />
                <select id="uf" wire:model.defer="form.uf"
                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                    <option value="">Selecione</option>
                    <option value="ce">CE</option>
                </select>
                <x-input-error for="form.uf" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-label for="phone" value="{{ __('Telefone') }}" />
                <x-input id="phone" type="text" class="mt-1 block w-full" wire:model.defer="form.phone" />
                <x-input-error for="form.phone" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-label for="cell_phone" value="{{ __('Celular') }}" />
                <x-input id="cell_phone" type="text" class="mt-1 block w-full" wire:model.defer="form.cell_phone" />
                <x-input-error for="form.cell_phone" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-label for="church_relationship" value="{{ __('Relação com a igreja') }}" />
                <select id="church_relationship" wire:model.defer="form.church_relationship"
                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                    <option value="">Selecione</option>
                    @foreach ($this->optChurchRelationship as $opt)
                    <option value="{{ $opt->name }}">{{ $opt->value }}</option>
                    @endforeach
                </select>
                <x-input-error for="form.church_relationship" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-label for="entry_date" value="{{ __('Data da entrada') }}" />
                <input type="date" wire:model.defer="form.entry_date"
                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" />
                <x-input-error for="form.entry_date" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-label for="hou_meet" value="{{ __('Entrada por') }}" />
                <select id="hou_meet" wire:model.defer="form.hou_meet"
                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                    <option value="">Selecione</option>
                    @foreach ($this->optHouMeet as $opt)
                    <option value="{{ $opt->name }}">{{ $opt->value }}</option>
                    @endforeach
                </select>
                <x-input-error for="form.hou_meet" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-label for="church_from" value="{{ __('Igreja de onde veio') }}" />
                <x-input id="church_from" type="text" class="mt-1 block w-full" wire:model.defer="form.church_from" />
                <x-input-error for="form.church_from" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-label for="baptized" value="{{ __('Batizado') }}" />
                <select id="baptized" wire:model.defer="form.baptized"
                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                    <option value="">Selecione</option>
                    <option value="sim">Sim</option>
                    <option value="não">Não</option>
                </select>
                <x-input-error for="form.baptized" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-label for="accepted_jesus" value="{{ __('Aceitou Jessus') }}" />
                <select id="accepted_jesus" wire:model.defer="form.accepted_jesus"
                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                    <option value="">Selecione</option>
                    <option value="sim">Sim</option>
                    <option value="não">Não</option>
                </select>
                <x-input-error for="form.accepted_jesus" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-label for="date_accepted_jesus" value="{{ __('Data que aceitou Jessus') }}" />
                <input type="date" wire:model.defer="form.date_accepted_jesus"
                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" />
                <x-input-error for="form.date_accepted_jesus" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-label for="leader" value="{{ __('É lider') }}" />
                <select id="leader" wire:model.defer="form.leader"
                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                    <option value="">Selecione</option>
                    <option value="sim">Sim</option>
                    <option value="não">Não</option>
                </select>
                <x-input-error for="form.leader" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-label for="pastor" value="{{ __('É pastor') }}" />
                <select id="pastor" wire:model.defer="form.pastor"
                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                    <option value="">Selecione</option>
                    <option value="sim">Sim</option>
                    <option value="não">Não</option>
                </select>
                <x-input-error for="form.pastor" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-label for="Schooling" value="{{ __('Escolaridade') }}" />
                <select id="Schooling" wire:model.defer="form.Schooling"
                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                    <option value="">Selecione</option>
                    @foreach ($this->optSchooling as $opt)
                    <option value="{{ $opt->name }}">{{ $opt->value }}</option>
                    @endforeach
                </select>
                <x-input-error for="form.Schooling" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-label for="profession" value="{{ __('Profissão') }}" />
                <x-input id="profession" type="text" class="mt-1 block w-full" wire:model.defer="form.profession" />
                <x-input-error for="form.profession" class="mt-2" />
            </div>


        </x-slot>


        <x-slot name="actions">
            @if (session()->has('message'))
            <x-alert-message :message="session('message')['text']" :messageType="session('message')['type']" />
            @endif

            <x-button wire:click.prevent="store()">
                {{ __('Save') }}
            </x-button>
        </x-slot>
    </x-form-section>
</div>
